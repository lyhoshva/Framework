<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 06.11.2016
 * Time: 19:15
 */

namespace Framework\Response;


abstract class Formatter implements FormatterInterface
{
    const FORMAT_RAW = 'raw';
    const FORMAT_JSON = 'json';
    const FORMAT_HTML = 'html';

    /**
     * Convert response to defined format
     * @param ResponseInterface $response
     */
    public function prepare(ResponseInterface $response)
    {
        static::addHeaders($response);
        static::prepareBody($response);
    }

    /**
     * Add specific headers to $response
     * @param ResponseInterface $response
     */
    protected function addHeaders(ResponseInterface $response)
    {
        //empty
    }

    /**
     * Convert response body to defined format
     * @param ResponseInterface $response
     * @return string
     */
    protected function prepareBody(ResponseInterface $response)
    {
        //empty
    }
}
