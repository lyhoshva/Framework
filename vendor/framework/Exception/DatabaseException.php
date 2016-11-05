<?php

namespace Framework\Exception;

use Exception;

/**
 * Class DatabaseException
 * @package Framework\Exception
 */
class DatabaseException extends Exception
{
    public function __construct($message = 'Database Exception')
    {
        $this->message = $message;
        $this->code = 500;
    }
}
