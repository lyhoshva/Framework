<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 06.11.2016
 * Time: 19:08
 */

namespace Framework\Response;


class JsonFormatter extends Formatter
{
    protected function addHeaders(ResponseInterface $response)
    {
        $response->setHeader('Content-Type', 'application/json; charset=UTF-8');
    }

    protected function prepareBody(ResponseInterface $response)
    {
        $response->body = json_encode($response->body);
    }
}
