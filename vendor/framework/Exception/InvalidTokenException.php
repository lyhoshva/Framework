<?php

namespace Framework\Exception;

class InvalidTokenException extends \Exception
{
    /**
     * InvalidTokenException constructor.
     * @param string $message
     */
    public function __construct($message = 'Invalid token')
    {
        $this->code = '403';
        $this->message = $message;
    }
}
