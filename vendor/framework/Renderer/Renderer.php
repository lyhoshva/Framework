<?php

namespace Framework\Renderer;

use Framework\DI\Service;
use Loader;

/**
 * Class Renderer
 * @package Framework\Renderer
 */
class Renderer implements RendererInterface
{
    protected $title;
    protected $description;
    protected $keywords;
    protected $params = [];
    protected $main_layout;
    protected $route;

    /**
     * Renderer constructor.
     * @param $main_layout
     */
    public function __construct($main_layout)
    {
        $this->main_layout = $main_layout;
        //TODO Check after changing ServiceLocator
        $this->route = Service::get('router')->getCurrentRoute();
    }

    /**
     * Renders layout
     *
     * @param $content
     * @param bool|false $layout
     * @return string
     */
    public function renderLayout($content, $layout = false)
    {
        if ($layout) {
            $template = $layout;
        } else {
            $template = $this->main_layout;
        }

        $session = Service::get('session');
        $flush = $session->getFlush();
        $session->clearFlush();
        $user = Service::get('security')->getUser();

        return $this->render($template, compact('content', 'flush', 'user'), false);
    }

    /**
     * Renders view
     *
     * @param $view
     * @param array $data
     * @param bool|true $wrap_layout
     * @param bool|false $layout
     * @return string
     */
    public function render($view, $data = array(), $wrap_layout = false, $layout = false)
    {
        extract($data);
        $include = function($controller, $action, $params) {
            Service::get('app')->getResponse($controller, $action, $params)->send();
        };

        ob_start();

        include($view);
        $content = ob_get_clean();

        if ($wrap_layout) {
            $content = $this->renderLayout($content , $layout);
        }

        return $content;
    }

    /**
     * Returns hidden input with csrf token
     * @return string
     */
    protected function getTokenInput()
    {
        return '<input type="hidden" name="_csrf" value="' .  Service::get('security')->getToken() . '">';
    }

    /**
     * Returns url to route
     * 
     * @param $route 
     * @return string
     */
    protected function getRouteUrl($route)
    {
        return Service::get('router')->generateRoute($route);
    }

    /**
     * Returns path to view
     *
     * @param $view
     * @param $classname
     * @return string
     */
    public function getViewPath($view, $classname)
    {
        $config = Service::get('app')->config;
        $controller_dir = $config['base_path'] . 'src/' . preg_replace('~Controller$~', '/', $classname);
        return str_replace(DIRECTORY_SEPARATOR . 'Controller' . DIRECTORY_SEPARATOR, '/views/', $controller_dir) . $view . '.php';
    }
}
