<?php

namespace Framework\Request;

/**
 * Class Request
 * @package Framework\Request
 */
class Request
{
    /**
     * Returns request method
     *
     * @return string
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Checks that REQUEST_METHOD is POST
     *
     * @return bool
     */
    public function isPost()
    {
        return ($this->getMethod()=='POST');
    }

    /**
     * Checks that REQUEST_METHOD is GET
     *
     * @return bool
     */
    public function isGet()
    {
        return ($this->getMethod()=='GET');
    }


    /**
     * Returns variable from $_POST
     *
     * @param string $name
     * @return string
     */
    public function post($name)
    {
        //@TODO Add filtration
        return isset($_POST[$name]) ? $_POST[$name] : null;
    }

    /**
     * Returns variable from $_GET
     *
     * @param string $name
     * @return string
     */
    public function get($name)
    {
        //@TODO Add filtration
        return isset($_GET[$name]) ? $_GET[$name] : null;
    }

    /**
     * Returns variable from $_COOKIE
     *
     * @param string $name
     * @return string
     */
    public function cookie($name)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

    /**
     * Returns headers
     *
     * @param string|null $header
     * @return array|null
     */
    public function getHeaders($header = null)
    {
        $data = apache_request_headers();
        if(!empty($header)){
            $data = array_key_exists($header, $data) ? $data[$header] : null;
        }

        return $data;
    }
}
