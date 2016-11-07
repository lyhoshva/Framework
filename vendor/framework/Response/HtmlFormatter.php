<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 06.11.2016
 * Time: 19:31
 */

namespace Framework\Response;

class HtmlFormatter extends Formatter
{
    protected function addHeaders(ResponseInterface $response)
    {
        $response->setHeader('Content-Type', 'text/html');
    }
}
