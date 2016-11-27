<?php

namespace Framework\Controller;

use Framework\DI\Service;
use Framework\Request\Request;
use Framework\Response\Response;

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

        return $renderer->render($view, $data, true, $layout);
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

        return $renderer->render($view, $data, false);
    }

    /**
     * Redirect application
     *
     * @param string $redirect_to
     * @param string $message
     * @param int $code
     * @return Response
     */
    public function redirect($redirect_to, $message = '', $code = 302)
    {
        if (!empty($message)) {
            Service::get('session')->addFlush('info', $message);
        }

        $response = new Response();
        return $response->redirect($redirect_to, $code);
    }

    /**
     * Generate path to route
     *
     * @param $route
     * @param array $params
     * @return mixed
     */
    public function generateRoute($route, array $params = [])
    {
        $router = Service::get('router');
        return $router->generateRoute($route, $params);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return Service::get('request');
    }
}
