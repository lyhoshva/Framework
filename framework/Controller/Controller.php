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
     * Render view
     *
     * @param $view
     * @param array $data
     * @param bool|true $wrap_layout
     * @param bool|false $layout
     * @return Response
     */
    public function render($view, $data = array(), $wrap_layout = true, $layout = false)
    {
        $renderer = Service::get('renderer');
        $view = $renderer->getViewPath($view, get_called_class());

        return new Response($renderer->render($view, $data, $wrap_layout, $layout));
    }

    /**
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
