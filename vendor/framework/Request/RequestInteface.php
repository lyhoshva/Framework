<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.11.2016
 * Time: 19:20
 */

namespace Framework\Request;


interface RequestInteface
{
    /**
     * Returns request method
     *
     * @return string
     */
    public function getMethod();

    /**
     * Returns request method
     *
     * @return string
     */
    public function getUri();

    /**
     * Checks that REQUEST_METHOD is POST
     *
     * @return bool
     */
    public function isPost();

    /**
     * Checks that REQUEST_METHOD is GET
     *
     * @return bool
     */
    public function isGet();

    /**
     * Returns variable from $_POST
     *
     * @param string $name
     * @return string
     */
    public function post($name);

    /**
     * Returns variable from $_GET
     *
     * @param string $name
     * @return string
     */
    public function get($name);

    /**
     * Returns variable from $_COOKIE
     *
     * @param string $name
     * @return string
     */
    public function cookie($name);

    /**
     * Returns headers
     *
     * @param string|null $header
     * @return array|null
     */
    public function getHeaders($header);
}
