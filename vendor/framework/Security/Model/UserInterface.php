<?php

namespace Framework\Security\Model;

interface UserInterface
{
    /**
     * Return user role
     *
     * @return string
     */
    public function getRole();

    /**
     * Verify password
     *
     * @param $password string
     * @return bool
     */
    public function verifyPassword($password);
}
