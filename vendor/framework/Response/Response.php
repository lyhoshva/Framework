<?php

namespace Framework\Response;
use Framework\DI\Service;
use Framework\Exception\BadResponseTypeException;

/**
 * Class Response
 * @package Framework\Response
 */
class Response implements ResponseInterface
{
    public $body;
    protected $code;

    /**
     * Response headers
     * @var array
     */
    protected $headers = array();

    public static $httpStatuses = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        118 => 'Connection timed out',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        210 => 'Content Different',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        310 => 'Too many Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested range unsatisfiable',
        417 => 'Expectation failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable entity',
        423 => 'Locked',
        424 => 'Method failure',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        449 => 'Retry With',
        450 => 'Blocked by Windows Parental Controls',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway or Proxy Error',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        507 => 'Insufficient storage',
        508 => 'Loop Detected',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

    /**
     * Response constructor.
     * @param string $body
     * @param int $code
     */
    public function __construct($body = '', $code = 200)
    {
        $this->body = $body;
        $this->code = $code;
    }

    /**
     * Array of available formatters
     * @return array
     */
    protected function getFormatters()
    {
        return [
            Formatter::FORMAT_RAW => 'Framework\Response\RawFormatter',
            Formatter::FORMAT_JSON => 'Framework\Response\JsonFormatter',
            Formatter::FORMAT_HTML => 'Framework\Response\HtmlFormatter',
        ];
    }

    /**
     * Adds an element to headers array
     * @param $name string
     * @param $value string
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * Sends response headers
     */
    protected function sendHeaders()
    {
        header($_SERVER['SERVER_PROTOCOL'].' '.$this->code.' '.self::$httpStatuses[$this->code]);
        foreach($this->headers as $name => $value){
            header(sprintf("%s: %s", $name, $value));
        }
    }

    /**
     *  Sends response body
     */
    protected function sendBody()
    {
        echo $this->body;
    }

    /**
     *  Sends response headers and body
     */
    public function send()
    {
        $format = Service::get('app')->response_format;
        if (empty($this->getFormatters()[$format])) {
            throw new BadResponseTypeException('Bad Response format type ' . $format);
        }
        $formatter_name = $this->getFormatters()[$format];
        $formatter = new $formatter_name();
        $formatter->prepare($this);
        $this->sendHeaders();
        $this->sendBody();
    }

    /**
     * Send redirect header to defined $uri
     *
     * @param $uri
     * @param int $code
     * @return $this
     * @throws BadResponseTypeException
     */
    public function redirect($uri, $code = 302)
    {
        if ($code < 300 || $code > 307) {
            throw new BadResponseTypeException('Incorrect redirect code ' . $code);
        }
        Service::get('app')->response_format = Formatter::FORMAT_RAW;
        $this->setHeader('Location', $uri);
        $this->body = ' ';
        $this->code = $code;

        return $this;
    }
}
