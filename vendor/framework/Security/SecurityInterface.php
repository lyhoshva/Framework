<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.11.2016
 * Time: 19:22
 */

namespace Framework\Security;


interface SecurityInterface
{
    /**
     * Set user object
     *
     * @param $user
     */
    public function setUser($user);

    /**
     * Returns csrf token
     * Set new token if current is empty
     * @return string csrf-token
     */
    public function getToken();

    /**
     * Check CSRF token identity
     *
     * @return bool
     */
    public function validateToken();

    /**
     *  Clear CSRF token
     */
    public function clearToken();

    /**
     * Check is the user authenticated
     *
     * @return bool
     */
    public function isAuthenticated();

    /**
     * Return user
     *
     * @return object
     */
    public function getUser();

    /**
     * Clear security information
     */
    public function clear();

    /**
     * Checks whether user has permission to this route
     * @param array $route current route
     * @return bool
     * @throws HttpForbiddenException when user has not permission
     * @throws NotAuthException when user is not authorized
     */
    public function checkRoutePermission(array $route);

    /**
     * Checks whether user has permission
     * @param array $roles allowed roles
     * @return bool
     */
    public function checkPermission(array $roles);
    
    
}
