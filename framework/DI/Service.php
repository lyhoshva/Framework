<?php

namespace Framework\DI;

/**
 * Class Service
 * @package Framework\DI
 */
abstract class Service
{
    /**
     * @var array
     */
    private static $services = array();

    /**
     * Adds service
     *
     * @param string $name
     * @param $obj
     */
    public static function set($name, $obj)
    {
        self::$services[$name] = $obj;
    }

    /**
     * Returns service
     *
     * @param string $name
     * @return mixed
     */
    public static function get($name)
    {
        return array_key_exists($name, self::$services) ? self::$services[$name] : null;
    }
}
