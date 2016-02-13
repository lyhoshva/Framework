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
        $router = new Router(include('../app/config/routes.php'));

        $route = $router->parseRoute($_SERVER['REQUEST_URI']);

        print_r($route);
    }
}
