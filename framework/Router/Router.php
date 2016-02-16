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
     * @param $url
     * @return array|null
     */
    public function parseRoute($url)
    {
        $route_found = null;

        $url = preg_replace('~/$~', '', $url);

        foreach (self::$map as $route) {
            $pattern = $this->prepare($route);

            if (preg_match($pattern, $url, $params)) {

                // Get assoc array of params:
                preg_match('~{([\w\d_]+)}~', $route['pattern'], $param_names);
                $params = array_map('urldecode', $params);
                $params = array_combine($param_names, $params);
                array_shift($params); // Get rid of 0 element

                $route_found = $route;
                $route_found['params'] = $params;

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
        //TODO Make URL generating
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
