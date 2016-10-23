<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 23.10.2016
 * Time: 11:51
 */

namespace Framework\Cache;

use Framework\DI\Service;
use ReflectionClass;
use ReflectionMethod;

class Cache
{
    /**
     * Generates cache file and returns routing map
     *
     * @return array
     */
    public function getRouteMap()
    {
        $config = Service::get('app')->config;
        $route_cache_path = $config['base_path'] . 'app/cache/routes.php';

        if (($config['mode'] == 'prod' && !file_exists($route_cache_path)) || ($config['mode'] == 'dev')) {
            $routes = self::generateRouteMap();
        } else {
            $routes = file_get_contents($route_cache_path);
        }

        return $routes;
    }

    /**
     * Generates route map from config and annotations and writes it to cache
     *
     * @return array route map
     */
    public function generateRouteMap()
    {
        $config = Service::get('app')->config;
        $route_cache_path = $config['base_path'] . 'app/cache/routes.php';
        $controllers = array();

        $dir_path = $config['base_path'] . 'src/';
        $files = self::getDirectoryList($dir_path);
        $controller_dirs_path = array();

        //gets paths with "Controller" directory
        foreach ($files as $file) {
            $path = $file . '/Controller';
            if (file_exists($dir_path . $path)) {
                $controller_dirs_path[] = $path;
            }
        }

        //gets Controller`s files paths
        foreach ($controller_dirs_path as $dir) {
            $files = self::getDirectoryList($dir_path . $dir);

            foreach ($files as $file) {
                $path = $dir . '/' . $file;
                if (is_file($dir_path . '/' . $path) && preg_match('~[A-Za-z]+Controller.php~', $file)) {
                    $controllers[] = str_replace('/', '\\', str_replace('.php', '',$path));
                }
            }
        }

        $methods = array();

        foreach ($controllers as $controller) {
            $reflectionController = new ReflectionClass($controller);
            $methods = array_merge($methods, $reflectionController->getMethods(ReflectionMethod::IS_PUBLIC));
        }

        $actions = array_filter($methods, function ($var) {
            return preg_match('~^[A-Za-z]+Action$~', $var->name);
        });

        $routes = array();

        foreach ($actions as $action) {
            if (!empty($action->getDocComment())) {
                $phpDoc = $action->getDocComment();
                preg_match('~@Route\("(\w*)"\s*,\s*"(.*)"\s*(?:,\s*{(.*)})?\)~Um', $phpDoc, $matches);
                if (!empty($matches)) {
                    $routes[$matches[1]] = [
                        'pattern' => $matches[2],
                        'controller' => $action->class,
                        'action' => str_replace('Action', '', $action->name)
                    ];

                    $requirements = $matches[3];
                    if (!empty($requirements)) {
                        preg_match_all('~(\w+)\s*:\s"(.+)"[\s,]*?~U', $requirements, $requirement_matches);
                        if (!empty($requirement_matches)) {
                            $routes[$matches[1]]['_requirements'] = array_combine($requirement_matches[1], $requirement_matches[2]);
                        }
                    }
                }
            }
        }
        $routes = array_merge($routes, $config['routes']);
        file_put_contents($route_cache_path, serialize($routes));

        return $routes;
    }

    /**
     * Returns a list of directory
     * Deletes current and parent directory from list
     *
     * @param $path directory path
     * @return array
     */
    protected function getDirectoryList($path)
    {
        $list = scandir($path);
        unset($list[0]);   //unset directory "."
        unset($list[1]);   //unset directory ".."

        return $list;
    }
}
