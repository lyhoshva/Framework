<?php

namespace Framework;

use Exception;
use Framework\DI\Service;
use Framework\DI\ServiceFactory;
use Framework\Exception\BadResponseTypeException;
use Framework\Exception\BadServiceConfigException;
use Framework\Exception\HttpForbiddenException;
use Framework\Exception\HttpNotFoundException;
use Framework\Exception\InvalidInterfaceException;
use Framework\Exception\InvalidTokenException;
use Framework\Exception\NotAuthException;
use Framework\Exception\UndefinedServiceException;
use Framework\Response\Formatter;
use Framework\Response\Response;
use ReflectionClass;

/**
 * Class Application
 * @package Framework
 */
class Application
{
    public $config;
    public $response_format = Formatter::FORMAT_HTML;

    /**
     * Application constructor.
     * @param string $config_path
     */
    public function __construct($config_path)
    {
        $this->config = include($config_path);

        ini_set('display_errors', $this->config['mode'] == 'dev' ? '1' : '0');

        Service::set('app', $this);
        ServiceFactory::setConfig($this->config);
    }

    /**
     * Run the application
     *
     * @throws InvalidTokenException
     * @throws HttpNotFoundException
     * @throws BadResponseTypeException
     */
    public function run()
    {
        try {
            $router = Service::get('router');
            $request = Service::get('request');
            $security = Service::get('security');

            if ($request->isPost()) {
                if ($security->validateToken()) {
                    $security->clearToken();
                } else {
                    throw new InvalidTokenException();
                }
            }

            $route = $router->parseRoute();
            if (!empty($route) && $security->checkRoutePermission($route)) {
                $response = $this->executeAction($route['controller'], $route['action'], isset($route['params']) ? $route['params'] : []);
                if (!($response instanceof Response)) {
                    $response = new Response($response);
                }
            } else {
                throw new HttpNotFoundException('Route Not Found');
            }

        } catch(HttpNotFoundException $e) {
            $response = $this->renderError($e);
        } catch(HttpForbiddenException $e) {
            $response = $this->renderError($e);
        } catch(InvalidInterfaceException $e) {
            $response = $this->renderError($e);
        } catch(UndefinedServiceException $e) {
            $response = $this->renderError($e);
        } catch(BadServiceConfigException $e) {
            $response = $this->renderError($e);
        } catch(BadResponseTypeException $e) {
            $response = $this->renderError($e);
        } catch(InvalidTokenException $e) {
            $response = $this->renderError($e);
        } catch(NotAuthException $e) {
            $session = Service::get('session');
            $current_route = $router->getCurrentRoute();
            $session->returnUrl = $router->generateRoute($current_route['_name'], $current_route['params']);
            $session->addFlush('info', 'You have to be logged in for this operation');
            $response = new Response();
            $response->redirect($router->generateRoute($this->config['security']['login_route']));
        } catch(Exception $e) {
            $response = $this->renderError($e);
        }
        $response->send();
    }

    /**
     * Gets response object from controller method
     *
     * @param string $class class name
     * @param string $method method name
     * @param array $params
     * @return mixed
     */
    public function executeAction($class, $method, $params = [])
    {
        $response = null;

        if (!is_array($params)) {
            $params = [];
        }

        $reflectionController = new ReflectionClass($class);
        $action = $method . 'Action';

        if ($reflectionController->hasMethod($action)) {
            $controllerInstance = $reflectionController->newInstance();
            $actionReflection = $reflectionController->getMethod($action);

            $response = $actionReflection->invokeArgs($controllerInstance, $params);
        }

        return $response;
    }

    /**
     * Render error view
     *
     * @param $e
     * @return Response
     */
    protected function renderError($e)
    {
        return new Response(Service::get('renderer')->render($this->config['error_view'], [
            'code' =>  $e->getCode(),
            'message' =>  $e->getMessage(),
        ], true), $e->getCode());
    }
}
