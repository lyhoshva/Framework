<?php

namespace Framework\Controller;

use Framework\DI\Service;
use Framework\Response\ResponseRedirect;

class Controller
{
    public function redirect($redirect_to, $message = '')
    {
        //@TODO Add message implementation
        return new ResponseRedirect($redirect_to);
    }

    public function generateRoute($route)
    {
        $router = Service::get('router');
        return $router->generateRoute($route);
    }

    public function getRequest()
    {
        return Service::get('request');
    }
}
