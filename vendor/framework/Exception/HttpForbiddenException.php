<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 22.10.2016
 * Time: 10:52
 */

namespace Framework\Exception;

use Exception;

/**
 * Class HttpForbiddenException
 * @package Framework\Exception
 */
class HttpForbiddenException extends Exception
{
    /**
     * HttpNotFoundException constructor.
     * @param string $message
     */
    public function __construct($message = 'Forbidden')
    {
        $this->message = $message;
        $this->code = '403';
    }
}
