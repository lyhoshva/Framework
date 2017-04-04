<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.11.2016
 * Time: 12:12
 */

namespace Framework\DI;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Framework\Cache\Cache;
use Framework\Exception\BadServiceConfigException;
use Framework\Exception\InvalidInterfaceException;
use Framework\Exception\UndefinedServiceException;
use Framework\Renderer\Renderer;
use Framework\Request\Request;
use Framework\Router\Router;
use Framework\Security\Security;
use Framework\Session\Session;

class ServiceFactory
{
    const CONFIG_SERVICE_KEY = 'services';

    protected static $config = [];

    //TODO Add doctrine interface after inplementing Doctrine wrapper
    protected static $interfaces = [
        'cache' => 'Framework\Cache\CacheInterface',
        'router' => 'Framework\Router\RouterInterface',
        'renderer' => 'Framework\Renderer\RendererInterface',
        'session' => 'Framework\Session\SessionInterface',
        'security' => 'Framework\Security\SecurityInterface',
        'request' => 'Framework\Request\RequestInterface',
    ];

    /**
     * Set application config
     *
     * @param array $config
     */
    public static function setConfig(array $config)
    {
        self::$config = $config;
    }

    /**
     * Initialize Service
     *
     * @param $name string Service name
     * @return object Service object
     * @throws BadServiceConfigException
     * @throws UndefinedServiceException
     */
    public static function initService($name)
    {
        if (empty(self::$config[self::CONFIG_SERVICE_KEY][$name])) {
            return self::initBaseService($name);
        } else {
            return self::initConfigService($name);
        }
    }

    /**
     * Initialize Service defined by config
     *
     * @param $name string Service name
     * @return object Service object
     * @throws BadServiceConfigException
     * @throws InvalidInterfaceException
     */
    protected static function initConfigService($name)
    {
        $service_config = self::$config[self::CONFIG_SERVICE_KEY][$name];
        if (empty($service_config['class'])) {
            throw new BadServiceConfigException("Service \"$name\" config have to contain \"class\" section with service classname");
        }
        $service_classname = $service_config['class'];
        unset($service_config['class']);

        $reflection_class = new \ReflectionClass($service_classname);
        if (!empty(self::$interfaces[$name]) && !$reflection_class->implementsInterface(self::$interfaces[$name])) {
            throw new InvalidInterfaceException('Service "' . ucfirst($name) . '" have to implements interface "' . self::$interfaces[$name] . '"');
        }
        return $reflection_class->newInstanceArgs($service_config);
    }

    /**
     * Initialize base Framework service
     *
     * @param $name string Service name
     * @return object Service object
     * @throws UndefinedServiceException
     */
    protected static function initBaseService($name)
    {
        $method_name = 'get' . ucfirst($name);
        if (method_exists(__CLASS__, $method_name)) {
            return self::$method_name();
        }

        throw new UndefinedServiceException("Service $name does not defined");
    }

    protected static function getCache()
    {
        return new Cache();
    }

    protected static function getRouter()
    {
        $route_map = Service::get('cache')->getRouteMap();
        return new Router($route_map);
    }

    protected static function getRenderer()
    {
        return new Renderer(self::$config['main_layout']);
    }

    protected static function getDoctrine()
    {
        $isDevMode = (self::$config['mode'] == 'dev');
        $paths_to_entities = Service::get('cache')->getPathsToEntities();
        $doctrineConfig = Setup::createAnnotationMetadataConfiguration($paths_to_entities, $isDevMode);
        return EntityManager::create(self::$config['db'], $doctrineConfig);
    }

    protected static function getSession()
    {
        return new Session();
    }

    protected static function getSecurity()
    {
        return new Security();
    }

    protected static function getRequest()
    {
        return new Request();
    }
}
