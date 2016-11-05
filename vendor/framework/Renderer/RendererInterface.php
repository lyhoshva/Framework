<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.11.2016
 * Time: 19:19
 */

namespace Framework\Renderer;


interface RendererInterface
{
    /**
     * Renderer constructor.
     * @param $main_layout
     */
    public function __construct($main_layout);

    /**
     * Renders layout
     *
     * @param $content
     * @param bool|false $layout
     * @return string
     */
    public function renderLayout($content, $layout);

    /**
     * Renders view
     *
     * @param $view
     * @param array $data
     * @param bool|true $wrap_layout
     * @param bool|false $layout
     * @return string
     */
    public function render($view, $data, $wrap_layout, $layout);

    /**
     * Returns path to view
     *
     * @param $view
     * @param $classname
     * @return string
     */
    public function getViewPath($view, $classname);
}
