<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.11.2016
 * Time: 12:31
 */

namespace Framework\Exception;


class BadFormatTypeException extends \Exception
{
    /**
     * UndefinedServiceException constructor.
     * @param string $message
     */
    public function __construct($message = 'Bad Response format type')
    {
        $this->message = $message;
        $this->code = 500;
    }
}
