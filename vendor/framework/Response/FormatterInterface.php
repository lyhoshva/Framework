<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 06.11.2016
 * Time: 15:38
 */

namespace Framework\Response;


interface FormatterInterface
{
    /**
     * Convert response to defined format
     */
    public function prepare(ResponseInterface $response);
}
