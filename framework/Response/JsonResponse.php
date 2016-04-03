<?php

namespace Framework\Response;

/**
 * Class JsonResponse
 * @package Framework\Response
 */
class JsonResponse extends Response
{
    /**
     * JsonResponse constructor.
     * @param string $body
     * @param int $code
     */
    public function __construct($body, $code = 200)
    {
        $this->type = 'application/json; charset=UTF-8';
        $body = json_encode($body);
        parent::__construct($body, $this->type, $code);
    }
}
