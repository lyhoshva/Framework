<?php

namespace Framework\Session;

/**
 * Class Session
 * @package Framework\Session
 */
class Session
{

    /**
     * Session constructor.
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Session destructor.
     */
    public function __destruct()
    {
        session_destroy();
    }

    /**
     * @param string $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return !empty($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    /**
     * @param $name
     */
    public function __unset($name)
    {
        $_SESSION[$name] = null;
    }

    /**
     * Adds message to Flush
     *
     * @param string $type
     * @param $message
     */
    public function setFlush($type, $message)
    {
        $_SESSION['flush'][$type][] = $message;
    }

    /**
     * Returns Flush messages
     *
     * @return mixed
     */
    public function getFlush()
    {
        return !empty($_SESSION['flush']) ? $_SESSION['flush'] : array();
    }

    /**
     * Clears Flush messages
     */
    public function clearFlush()
    {
        $_SESSION['flush'] = null;
    }
}
