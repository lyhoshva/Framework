<?php

namespace Framework\Exception;

use Exception;

/**
 * Class BadResponseTypeException
 * @package Framework\Exception
 */
class BadResponseTypeException extends Exception
{
    /**
     * BadResponseTypeException constructor.
     * @param string $message
     */
    public function __construct($message = 'Bad Response Type')
    {
        $this->message = $message;
        $this->code = 500;
    }
}
