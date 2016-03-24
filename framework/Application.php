<?php

namespace Framework;

use Exception;
use Framework\DI\Service;
use Framework\Exception\BadResponseTypeException;
use Framework\Exception\HttpNotFoundException;
use Framework\Exception\NotAuthException;
use Framework\Renderer\Renderer;
use Framework\Response\Response;
use Framework\Response\ResponseRedirect;
use Framework\Router\Router;
use Framework\Session\Session;
use ReflectionClass;

/**
 * Class Application
 * @package Framework
 */
class Application
{
    public $config;

    /**
     * Application constructor.
     * @param string $config_path
     */
    public function __construct($config_path)
    {
        $this->config = include($config_path);
        Service::set('router', new Router($this->config['routes']));
        Service::set('renderer', new Renderer($this->config['main_layout']));
        Service::set('session', new Session());
        Service::set('db', new \PDO(
            $this->config['pdo']['dsn'],
            $this->config['pdo']['user'],
            $this->config['pdo']['password']
        ));
        Service::set('app', $this);
    }

    public function run()
    {
        $router = Service::get('router');
        $route = $router->parseRoute();
        try {
            if (!empty($route)) {
                $response = $this->getResponse($route['controller'], $route['action'], $route['params']);
            } else {
                throw new HttpNotFoundException('Route Not Found');
            }

            if (!($response instanceof Response)) {
                throw new BadResponseTypeException();
            }

        } catch(HttpNotFoundException $e) {
            $response = $this->renderError($e);
        } catch(BadResponseTypeException $e) {
            $response = $this->renderError($e);
        } catch(NotAuthException $e) {
            $response = new ResponseRedirect($router->generateRoute('signin'));
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
     * @return mixed|null
     */
    public function getResponse($class, $method, $params = array())
    {
        $response = null;

        if (!is_array($params)) {
            $params = array();
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
        return new Response(Service::get('renderer')->render($this->config['error_500'], [
            'code' =>  $e->getCode(),
            'message' =>  $e->getMessage(),
        ]));
    }
}
