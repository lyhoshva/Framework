<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.11.2016
 * Time: 12:31
 */

namespace Framework\Exception;


class BadServiceConfigException extends \Exception
{
    /**
     * BadServiceConfigException constructor.
     * @param string $message
     */
    public function __construct($message = 'Bad service config')
    {
        $this->message = $message;
        $this->code = 500;
    }
}
