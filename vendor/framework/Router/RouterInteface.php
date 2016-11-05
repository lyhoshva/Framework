<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.11.2016
 * Time: 19:21
 */

namespace Framework\Router;


interface RouterInteface
{
    /**
     * Router constructor.
     *
     * @param array $routing_map
     */
    public function __construct($routing_map);

    /**
     * Parses URL
     *
     * @param string $url
     * @return array|null
     * @throws NotAuthException
     */
    public function parseRoute($url);

    /**
     * Returns current route array
     *
     * @return array
     */
    public function getCurrentRoute();

    /**
     * Generates url to route
     *
     * @param string $route_name
     * @param array $params
     * @return string
     * @throws HttpNotFoundException
     */
    public function generateRoute($route_name, $params);
    
    
}
