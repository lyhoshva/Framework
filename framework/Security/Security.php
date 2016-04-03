<?php

namespace Framework\Security;

use Framework\DI\Service;
use Framework\Request\Request;

/**
 * Class Security
 * @package Framework\Security
 */
class Security
{
    /**
     * @var null
     */
    protected $user = null;

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
     * @param $user
     */
    public function setUser($user)
    {
        Service::get('session')->security = ['user' => ['id' => $user->id]];
        $this->getUserObject();
    }

    /**
     * Generate CSRF security token
     *
     * @return string
     */
    public function generateToken()
    {
        $token = base64_encode( openssl_random_pseudo_bytes(32));
        Service::get('session')->_csrf = $token;
        setcookie('_csrf', $token, time() + 1800); //seconds per 30 minutes

        return $token;
    }

    /**
     * Check CSRF token identity
     *
     * @return bool
     */
    public function validateToken()
    {
        $request = new Request();
        $postToken = $request->post('_csrf');
        $cookieToken = $request->cookie('_csrf');
        $sessionToken = Service::get('session')->_csrf;

        if (($postToken == $sessionToken) && ($cookieToken == $sessionToken)) {
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
            $this->user = $user_class::findById($security['user']['id']);
        }
    }

    /**
     * Return user
     *
     * @return null
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
}