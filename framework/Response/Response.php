<?php

namespace Framework\Response;

/**
 * Class Response
 * @package Framework\Response
 */
class Response
{
    /**
     * Response headers
     * @var array
     */
    protected $headers = array();

    public $code = 200;
    public $type = 'text/html';
    public $body = '';

    public static $httpStatuses = [
        200 => 'OK',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
    ];

    /**
     * Response constructor.
     * @param string $body
     * @param string $type
     * @param int $code
     */
    public function __construct($body = '', $type = 'text/html', $code = 200)
    {
        $this->body = $body;
        $this->type = $type;
        $this->code = $code;
        $this->setHeader('Content-Type', $type);
    }

    /**
     * Adds an element to headers array
     * @param $name
     * @param $value
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * Sends response headers
     */
    public function sendHeaders(){
        header($_SERVER['SERVER_PROTOCOL'].' '.$this->code.' '.self::$httpStatuses[$this->code]);
        foreach($this->headers as $name => $value){
            header(sprintf("%s: %s", $name, $value));
        }
    }

    /**
     *  Sends response body
     */
    public function sendBody(){
        echo $this->body;
    }
}
