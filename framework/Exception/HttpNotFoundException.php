<?php

namespace Framework\Exception;

use Exception;

/**
 * Class HttpNotFoundException
 * @package Framework\Exception
 */
class HttpNotFoundException extends Exception
{
    /**
     * HttpNotFoundException constructor.
     * @param string $message
     */
    public function __construct($message = 'Page not found')
    {
        $this->message = $message;
        $this->code = '404';
    }
}