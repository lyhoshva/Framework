<?php

namespace Framework\Router;

use Framework\DI\Service;
use Framework\Exception\HttpNotFoundException;
use Framework\Exception\NotAuthException;
use Framework\Request\Request;

/**
 * Class Router
 * @package Framework\Router
 */
class Router
{
    /**
     * @var array Routes map
     */
    protected static $map = array();
    /**
     * @var array Contains current route
     */
    protected $current_route = array();

    /**
     * Router constructor.
     *
     * @param array $routing_map
     */
    public function __construct($routing_map = array())
    {
        self::$map = $routing_map;
    }

    /**
     * Parses URL
     *
     * @param string $url
     * @return array|null
     * @throws NotAuthException
     */
    public function parseRoute($url = '')
    {
        $route_found = null;
        $request = new Request();
        $url = empty($url) ? $request->getUri() : $url;

        // Don`t replace slash on route "/"
        if ($url != '/') {
            $url = preg_replace('~/$~', '', $url);
        }

        foreach (self::$map as $key => $route) {
            $pattern = $this->prepare($route);

            if (preg_match($pattern, $url, $params)) {
                $security = Service::get('security');
                $this->current_route = $route;
                $this->current_route['_name'] = $key;

                if (isset($route['security'])) {
                    $roles = $route['security'];
                    $user_role = $security->isAuthenticated() ? Service::get('security')->getUser()->role : array();

                    if (array_search($user_role, $roles) === false) {
                        throw new NotAuthException();
                    }
                }

                // Get assoc array of params:
                preg_match('~{([\w\d_]+)}~', $route['pattern'], $param_names);
                $params = array_map('urldecode', $params);

                if (!empty($param_names)) {
                    $params = array_combine($param_names, $params);
                    array_shift($params); // Get rid of 0 element
                    $this->current_route['params'] = $params;
                }

                break;
            }

        }

        return $this->current_route;
    }

    /**
     * Returns current route array
     *
     * @return array
     */
    public function getCurrentRoute()
    {
        return $this->current_route;
    }

    /**
     * Generates url to route
     *
     * @param string $route_name
     * @param array $params
     * @return string
     * @throws HttpNotFoundException
     */
    public function generateRoute($route_name, $params = array())
    {
        $route_found['pattern'] = null;

        foreach (self::$map as $key => $route) {

            if ($route_name == $key) {

                if (!empty($params)) {
                    foreach ($params as $param_name => $param) {
                        $route['pattern'] = preg_replace('~{' . $param_name . '}~', $param, $route['pattern']);
                    }
                }

                preg_match('~{([\w\d_]+)}~', $route['pattern'], $param_undefined);

                if (!empty($param_undefined)) {
                    throw new HttpNotFoundException('Not Enough Parameters');
                }

                $route_found = $route;

                break;
            }
        }

        if (!$route_found) {
            throw new HttpNotFoundException('Page Not Found');
        }

        return $route_found['pattern'];
    }

    /**
     * Prepares URL to condition
     *
     * @param $route
     * @return string
     */
    private function prepare($route)
    {
        $pattern = $route['pattern'];

        if (!empty($route['_requirements'])) {
            foreach ($route['_requirements'] as $key => $requirement) {
                $pattern = str_replace('{' . $key . '}', '([' . $requirement . ']+)', $pattern);
            }
        }

        $pattern = '~^' . $pattern . '$~';

        return $pattern;
    }
}
