<?php

namespace Framework\Router;

use Framework\DI\Service;
use Framework\Exception\HttpNotFoundException;
use Framework\Exception\NotAuthException;
use Framework\Request\Request;
use ReflectionClass;
use ReflectionMethod;

/**
 * Class Router
 * @package Framework\Router
 */
class Router
{
    /**
     * @var array Routes map
     */
    protected static $map = array();
    /**
     * @var array Contains current route
     */
    protected $current_route = array();

    /**
     * Router constructor.
     *
     * @param array $routing_map
     */
    public function __construct($routing_map = array())
    {
        self::$map = $routing_map;
    }

    /**
     * Parses URL
     *
     * @param string $url
     * @return array|null
     * @throws NotAuthException
     */
    public function parseRoute($url = '')
    {
        $route_found = null;
        $request = new Request();
        $url = empty($url) ? $request->getUri() : $url;

        // Don`t replace slash on route "/"
        if ($url != '/') {
            $url = preg_replace('~/$~', '', $url);
        }

        foreach (self::$map as $key => $route) {
            $pattern = $this->prepare($route);

            if (preg_match($pattern, $url, $params)) {
                $security = Service::get('security');
                $this->current_route = $route;
                $this->current_route['_name'] = $key;

                if (isset($route['security'])) {
                    $roles = $route['security'];
                    $user_role = $security->isAuthenticated() ? Service::get('security')->getUser()->role : array();

                    if (array_search($user_role, $roles) === false) {
                        throw new NotAuthException();
                    }
                }

                // Get assoc array of params:
                preg_match('~{([\w\d_]+)}~', $route['pattern'], $param_names);
                $params = array_map('urldecode', $params);

                if (!empty($param_names)) {
                    $params = array_combine($param_names, $params);
                    array_shift($params); // Get rid of 0 element
                    $this->current_route['params'] = $params;
                }

                break;
            }

        }

        return $this->current_route;
    }

    /**
     * Returns current route array
     *
     * @return array
     */
    public function getCurrentRoute()
    {
        return $this->current_route;
    }

    /**
     * Generates url to route
     *
     * @param string $route_name
     * @param array $params
     * @return string
     * @throws HttpNotFoundException
     */
    public function generateRoute($route_name, $params = array())
    {
        $route_found['pattern'] = null;

        foreach (self::$map as $key => $route) {

            if ($route_name == $key) {

                if (!empty($params)) {
                    foreach ($params as $param_name => $param) {
                        $route['pattern'] = preg_replace('~{' . $param_name . '}~', $param, $route['pattern']);
                    }
                }

                preg_match('~{([\w\d_]+)}~', $route['pattern'], $param_undefined);

                if (!empty($param_undefined)) {
                    throw new HttpNotFoundException('Not Enough Parameters');
                }

                $route_found = $route;

                break;
            }
        }

        if (!$route_found) {
            throw new HttpNotFoundException('Page Not Found');
        }

        return $route_found['pattern'];
    }

    /**
     * Prepares URL to condition
     *
     * @param $route
     * @return string
     */
    private function prepare($route)
    {
        $pattern = $route['pattern'];

        if (!empty($route['_requirements'])) {
            foreach ($route['_requirements'] as $key => $requirement) {
                $pattern = str_replace('{' . $key . '}', '([' . $requirement . ']+)', $pattern);
            }
        }

        $pattern = '~^' . $pattern . '$~';

        return $pattern;
    }

    /**
     * Generates cache file and returns routing map 
     *
     * @return array
     */
    public static function getRouteMap()
    {
        $config = Service::get('app')->config;
        $route_cache_path = $config['base_path'] . 'app/cache/routes.php';

        if (($config['mode'] == 'prod' && !file_exists($route_cache_path)) || ($config['mode'] == 'dev')) {
            $controllers = array();
            $dir_path = $config['base_path'] . 'src/';
            $files = scandir($dir_path);
            unset($files[0]);   //unset directory "."
            unset($files[1]);   //unset directory ".."
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
                $files = scandir($dir_path . $dir);
                unset($files[0]);   //unset directory "."
                unset($files[1]);   //unset directory ".."

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
        } else {
            $routes = file_get_contents($route_cache_path);
        }

        return $routes;
    }
}
