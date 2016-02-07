<?php

/**
 * Class Loader
 */
class Loader
{
    public static $instance;
    public static $namespaces;

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Loading a class file
     * @param $classname
     */
    public static function load($classname)
    {
        //Taking first piece of namespace
        $first_piece = explode('\\', $classname)[0] . '\\';
        // Compare first piece of namespace with $namecpaces keys
        if (array_key_exists($first_piece, self::$namespaces)) {
            $path = str_replace($first_piece, '', $classname);
            $path = str_replace("\\", "/", $path);
            $path = self::$namespaces[$first_piece] . '/' . $path . '.php';
        } else {
            $path = str_replace('Framework', '', $classname);
            $path = __DIR__ . str_replace("\\", "/", $path) . '.php';
        }

        if (file_exists($path)) {
            include_once($path);
        }
    }

    /**
     * Add path for namespace
     * @param $namespace
     * @param $path
     */
    public static function addNamespacePath($namespace, $path)
    {
        self::$namespaces[$namespace] = $path;
    }

    private function __construct()
    {
        spl_autoload_register(array(__CLASS__, 'load'));
    }

    private function __clone()
    {
        // lock
    }

}

Loader::getInstance();
