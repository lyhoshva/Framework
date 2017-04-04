<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 06.11.2016
 * Time: 18:39
 */

namespace Framework\Response;


interface ResponseInterface
{
    /**
     * Response constructor.
     * @param string $body
     * @param int $code
     */
    public function __construct($body, $code);

    /**
     * Adds an element to headers array
     * @param $name string
     * @param $value string
     */
    public function setHeader($name, $value);

    /**
     *  Sends response headers and body
     */
    public function send();

    /**
     * Send redirect header to defined $uri
     *
     * @param $uri
     * @param int $code
     * @throws BadResponseTypeException
     */
    public function redirect($uri, $code);
}
