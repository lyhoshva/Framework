<?php

namespace Framework\DI;

class Service
{
    private static $services = array();

    public static function set($name, $obj)
    {
        self::$services[$name] = $obj;
    }

    public static function get($name)
    {
        return array_key_exists($name, self::$services) ? self::$services[$name] : null;
    }
}
