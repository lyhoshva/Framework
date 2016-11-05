<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.11.2016
 * Time: 19:23
 */

namespace Framework\Session;


interface SessionInterface
{
    /**
     * @param string $name
     * @param $value
     */
    public function __set($name, $value);

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name);

    /**
     * @param $name
     */
    public function __unset($name);

    /**
     * Adds message to Flush
     *
     * @param string $type
     * @param $message
     */
    public function addFlush($type, $message);

    /**
     * Returns Flush messages
     *
     * @return mixed
     */
    public function getFlush();

    /**
     * Clears Flush messages
     */
    public function clearFlush();
}
