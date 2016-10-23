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
     * Application config
     * @var array
     */
    protected $config = [];

    public function __construct()
    {
        $this->config = Service::get('app')->config;
    }

    /**
     * Generates cache file and returns routing map
     *
     * @return array
     */
    public function getRouteMap()
    {
        $route_cache_path = $this->config['base_path'] . 'app/cache/routes.php';

        if (($this->config['mode'] == 'prod' && !file_exists($route_cache_path)) || ($this->config['mode'] == 'dev')) {
            $routes = self::generateRouteMap($route_cache_path);
        } else {
            $routes = unserialize(file_get_contents($route_cache_path));
        }

        return $routes;
    }

    /**
     * Generates route map from config and annotations and writes it to cache
     *
     * @return array route map
     */
    protected function generateRouteMap($route_cache_path)
    {
        $controllers = array();
        $dir_path = $this->config['base_path'] . 'src/';

        $controller_dirs_path = self::getBundlesFolderPath('Controller', $dir_path);

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
        $routes = array_merge($routes, $this->config['routes']);
        file_put_contents($route_cache_path, serialize($routes));

        return $routes;
    }

    /**
     * Returns array of paths to entities for Doctrine ORM
     *
     * @return array
     */
    public function getPathsToEntities()
    {
        $path_to_entities_cache = $this->config['base_path'] . 'app/cache/path_to_entities.php';

        if (($this->config['mode'] == 'prod' && !file_exists($path_to_entities_cache)) || ($this->config['mode'] == 'dev')) {
            $path_to_entities = self::generatePathToEntities($path_to_entities_cache);
        } else {
            $path_to_entities = unserialize(file_get_contents($path_to_entities_cache));
        }

        return $path_to_entities;
    }

    /**
     * Generates array of paths to entities for Doctrine ORM and writes it to cache
     *
     * @return array route map
     */
    protected function generatePathToEntities($path_to_entities_cache)
    {
        $dir_path = $this->config['base_path'] . 'src/';
        $path_to_entities = self::getBundlesFolderPath('Entity', $dir_path);

        array_walk($path_to_entities, function(&$value) use ($dir_path){
            $value = $dir_path . $value;
        });

        file_put_contents($path_to_entities_cache, serialize($path_to_entities));

        return $path_to_entities;
    }

    /**
     * Returns array of paths from all bundles to $directory
     *
     * @param $directory directory name
     * @return array
     */
    protected function getBundlesFolderPath($directory, $src_path)
    {
        $bundle_dirs = self::getDirectoryList($src_path);
        $folder_paths = [];

        foreach ($bundle_dirs as $bundle_dir) {
            $path = $bundle_dir . '/' . $directory;
            if (file_exists($src_path . $path)) {
                $folder_paths[] = $path;
            }
        }

        return $folder_paths;
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
