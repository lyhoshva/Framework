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
     * Returns request method
     *
     * @return string
     */
    public function getUri()
    {
        return $_SERVER['REQUEST_URI'];
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
        if (isset ($_POST[$name])) {
            $var = htmlspecialchars($_POST[$name], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

            if ($name == 'password') {
                $var = md5($var);
            }
        }

        return isset($var) ? $var : null;
    }

    /**
     * Returns variable from $_GET
     *
     * @param string $name
     * @return string
     */
    public function get($name)
    {
        return isset($_GET[$name]) ? htmlspecialchars($_GET[$name], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : null;
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
