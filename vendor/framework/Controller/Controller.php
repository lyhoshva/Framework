<?php

namespace Framework\Controller;

use Framework\DI\Service;
use Framework\Request\Request;
use Framework\Response\Response;
use Framework\Response\ResponseRedirect;

/**
 * Class Controller
 * @package Framework\Controller
 */
class Controller
{
    /**
     * Render view with layout
     *
     * @param $view
     * @param array $data
     * @param bool|false $layout
     * @return Response
     */
    public function render($view, $data = array(), $layout = false)
    {
        $renderer = Service::get('renderer');
        $view = $renderer->getViewPath($view, get_called_class());

        return new Response($renderer->render($view, $data, true, $layout));
    }

    /**
     * Render view without layout
     *
     * @param $view
     * @param array $data
     * @return Response
     */
    public function renderPartial($view, $data = array())
    {
        $renderer = Service::get('renderer');
        $view = $renderer->getViewPath($view, get_called_class());

        return new Response($renderer->render($view, $data, false));
    }

    /**
     * Redirect application
     *
     * @param string $redirect_to
     * @param string $message
     * @return ResponseRedirect
     */
    public function redirect($redirect_to, $message = '')
    {
        if ($message) {
            Service::get('session')->addFlush('info', $message);
        }

        return new ResponseRedirect($redirect_to);
    }

    /**
     * Generate path to route
     *
     * @param $route
     * @return mixed
     */
    public function generateRoute($route)
    {
        $router = Service::get('router');
        return $router->generateRoute($route);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return new Request();
    }
}
