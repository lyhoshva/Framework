<?php

namespace Framework\Router;

/**
 * Class Router
 * @package Framework\Router
 */
class Router
{
    /**
     * @var array
     */
    protected static $map = array();

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
     */
    public function parseRoute($url = '')
    {
        $route_found = null;
        $url = empty($url) ? $_SERVER['REQUEST_URI'] : $url;
        $url = preg_replace('~/$~', '', $url);

        foreach (self::$map as $route) {
            $pattern = $this->prepare($route);

            if (preg_match($pattern, $url, $params)) {

                // Get assoc array of params:
                preg_match('~{([\w\d_]+)}~', $route['pattern'], $param_names);
                $params = array_map('urldecode', $params);

                if (!empty($param_names)) {
                    $params = array_combine($param_names, $params);
                    array_shift($params); // Get rid of 0 element
                    $route['params'] = $params;
                }

                $route_found = $route;

                break;
            }

        }

        return $route_found;
    }

    /**
     * Generates URL
     *
     * @param $route_name
     * @param array $params
     * @return string
     */
    public function generateRoute($route_name, $params = array())
    {
        //TODO Add Exception if the route can not be found
        $route_found['pattern'] = '/';

        foreach (self::$map as $key => $route) {

            if ($route_name == $key) {

                if (!empty($params)) {
                    foreach ($params as $param_name => $param) {
                        $route['pattern'] = preg_replace('~{' . $param_name . '}~', $param, $route['pattern']);
                    }
                }

                preg_match('~{([\w\d_]+)}~', $route['pattern'], $param_left);

                if (!empty($param_left)) {
                    //TODO Add Exception if not all parameters are defined
                    $route['pattern'] = '/';
                }

                $route_found = $route;

                break;
            }
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

        if ($route['_requirements']) {
            foreach ($route['_requirements'] as $key => $requirement) {
                $pattern = str_replace('{' . $key . '}', '([' . $requirement . ']+)', $pattern);
            }
        }

        $pattern = '~^' . $pattern . '$~';

        return $pattern;
    }
}
