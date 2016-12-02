<?php

namespace Framework\Security;

use Framework\DI\Service;
use Framework\Exception\HttpForbiddenException;
use Framework\Exception\NotAuthException;
use Shop\Model\User;

/**
 * Class Security
 * @package Framework\Security
 */
class Security implements SecurityInterface
{
    /**
     * @var null
     */
    protected $user = null;
    protected $token;

    /**
     * Security constructor.
     */
    public function __construct()
    {
        $this->getUserObject();
    }

    /**
     * Set user object
     *
     * @param $user User
     */
    public function setUser($user)
    {
        Service::get('session')->security = ['user' => ['id' => $user->getId()]];
        $this->getUserObject();
    }

    /**
     * Generate CSRF security token
     *
     * @return string
     */
    protected function generateToken()
    {
        $token = base64_encode( openssl_random_pseudo_bytes(32));
        Service::get('session')->_csrf = $token;

        return $token;
    }

    /**
     * Returns csrf token
     * Set new token if current is empty
     * @return string csrf-token
     */
    public function getToken()
    {
        if (empty($this->token)) {
            $this->token = $this->generateToken();
        }
        
        return $this->token;
    }

    /**
     * Check CSRF token identity
     *
     * @return bool
     */
    public function validateToken()
    {
        $request = Service::get('request');
        $postToken = $request->post('_csrf');
        $sessionToken = Service::get('session')->_csrf;

        if ($postToken == $sessionToken) {
            return true;
        }

        return false;
    }

    /**
     *  Clear CSRF token
     */
    public function clearToken()
    {
        setcookie('_csrf', '', 1);
        unset(Service::get('session')->_csrf);
    }

    /**
     * Check is the user authenticated
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        return isset($this->user);
    }

    /**
     *  Set user object attribute from db
     */
    protected function getUserObject()
    {
        $security = Service::get('session')->security;
        if (isset($security['user']['id'])) {
            $user_class = Service::get('app')->config['security']['user_class'];
            $this->user = $user_class::findOne($security['user']['id']);
        }
    }

    /**
     * Return user
     *
     * @return object
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Clear security information
     */
    public function clear()
    {
        $this->clearToken();
        unset($this->user);
        unset(Service::get('session')->security);
    }

    /**
     * Checks whether user has permission to this route
     * @param array $route current route
     * @return bool
     * @throws HttpForbiddenException when user has not permission
     * @throws NotAuthException when user is not authorized
     */
    public function checkRoutePermission(array $route)
    {
        if (isset($route['security'])) {
            $roles = $route['security'];

            if ($this->isAuthenticated()) {
                if (!$this->checkPermission($roles)) {
                    throw new HttpForbiddenException('You have not permission for this operation');
                }
            } else {
                throw new NotAuthException();
            }
        }
        
        return true;
    }

    /**
     * Checks whether user has permission
     * @param array $roles allowed roles
     * @return bool
     */
    public function checkPermission(array $roles)
    {
        if ($this->isAuthenticated()) {
            $user_role = $this->getUser()->getRole();

            if (array_search($user_role, $roles) !== false) {
                return true;
            } 
        } 
        
        return false;
    }
}
