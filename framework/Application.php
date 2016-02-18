<?php

namespace Framework;

use Framework\Router\Router;
/**
 * Class Application
 * @package Framework
 */
class Application
{
    public function run()
    {
        $config = include('../app/config/config.php');
        $router = new Router($config['routes']);

        $route = $router->parseRoute();

        print_r($route);
    }
}
