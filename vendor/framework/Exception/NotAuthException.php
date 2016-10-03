<?php

namespace Framework\Exception;

use Exception;

/**
 * Class NotAuthException
 * @package framework\Exception
 */
class NotAuthException extends Exception
{
    /**
     * NotAuthException constructor.
     */
    public function __construct()
    {
        $this->code = 401;
        $this->message = 'You are not authorized';
    }
}
