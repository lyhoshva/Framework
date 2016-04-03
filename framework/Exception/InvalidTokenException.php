<?php

namespace Framework\Exception;

class InvalidTokenException extends \Exception
{
    public function __construct($message = 'Invalid token')
    {
        $this->code = '403';
        $this->message = $message;
    }
}
