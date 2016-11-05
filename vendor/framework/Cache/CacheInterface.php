<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.11.2016
 * Time: 19:18
 */

namespace Framework\Cache;


interface CacheInterface
{
    /**
     * Generates cache file and returns routing map
     *
     * @return array
     */
    public function getRouteMap();

    /**
     * Returns array of paths to entities for Doctrine ORM
     *
     * @return array
     */
    public function getPathsToEntities();
}
