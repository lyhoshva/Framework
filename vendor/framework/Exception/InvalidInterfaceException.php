<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.11.2016
 * Time: 12:31
 */

namespace Framework\Exception;


class InvalidInterfaceException extends \Exception
{
    /**
     * InvalidInterfaceException constructor.
     * @param string $message
     */
    public function __construct($message = 'Invalid Interface')
    {
        $this->message = $message;
        $this->code = 500;
    }
}
