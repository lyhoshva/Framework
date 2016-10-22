<?php

namespace Framework;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Exception;
use Framework\DI\Service;
use Framework\Exception\BadResponseTypeException;
use Framework\Exception\HttpForbiddenException;
use Framework\Exception\HttpNotFoundException;
use Framework\Exception\InvalidTokenException;
use Framework\Exception\NotAuthException;
use Framework\Renderer\Renderer;
use Framework\Request\Request;
use Framework\Response\Response;
use Framework\Response\ResponseRedirect;
use Framework\Router\Router;
use Framework\Security\Security;
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

        ini_set('display_errors', $this->config == 'dev' ? '1' : '0');

        Service::set('app', $this);
        Service::set('router', new Router(Router::getRouteMap()));
        Service::set('renderer', new Renderer($this->config['main_layout']));
        $isDevMode = ($this->config['mode'] == 'dev');
        $paths = $this->config['paths_to_entities'];
        $doctrineConfig = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        Service::set('doctrine', EntityManager::create($this->config['db'], $doctrineConfig));
        Service::set('db', new \PDO(
            $this->config['pdo']['dsn'],
            $this->config['pdo']['user'],
            $this->config['pdo']['password']
        ));
        Service::set('session', new Session());
        Service::set('security', new Security());


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
        $router = Service::get('router');

        try {
            $request = new Request();
            $security = Service::get('security');

            if ($request->isPost() && !($security->validateToken())) {
                throw new InvalidTokenException();
            }

            $route = $router->parseRoute();
            if (!empty($route) && $security->checkRoutePermission($route)) {
                $security->clearToken();
                $response = $this->getResponse($route['controller'], $route['action'], isset($route['params']) ? $route['params'] : array());
            } else {
                throw new HttpNotFoundException('Route Not Found');
            }

            if (!($response instanceof Response)) {
                throw new BadResponseTypeException();
            }

        } catch(HttpNotFoundException $e) {
            $response = $this->renderError($e);
        } catch(HttpForbiddenException $e) {
            $response = $this->renderError($e);
        } catch(BadResponseTypeException $e) {
            $response = $this->renderError($e);
        } catch(InvalidTokenException $e) {
            $response = $this->renderError($e);
        } catch(NotAuthException $e) {
            $session = Service::get('session');
            $session->returnUrl = $router->getCurrentRoute()['pattern'];
            $session->addFlush('info', 'You have to be logged for this operation');
            $response = new ResponseRedirect($router->generateRoute($this->config['security']['login_route']));
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
