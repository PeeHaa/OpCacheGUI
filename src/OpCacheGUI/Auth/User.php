<?php
/**
 * Handles user authentication
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Auth
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2014 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Auth;

use OpCacheGUI\Storage\Session;

/**
 * Handles user authentication
 *
 * @category   OpCacheGUI
 * @package    Auth
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class User
{
    /**
     * @var \OpCacheGUI\Storage\Session The session
     */
    private $sessionStorage;

    /**
     * @var string The username
     */
    private $username;

    /**
     * @var string The password
     */
    private $password;

    /**
     * @var \OpCacheGUI\Auth\Whitelist Instance of a IP whitelist
     */
    private $whitelist;

    /**
     * Creates instance
     *
     * @param \OpCacheGUI\Storage\Session $sessionStorage The session
     * @param string                      $username       The username
     * @param string                      $password       The password
     */
    public function __construct(Session $sessionStorage, $username, $password, Whitelist $whitelist)
    {
        $this->sessionStorage = $sessionStorage;
        $this->username       = strtolower($username);
        $this->password       = $password;
        $this->whitelist      = $whitelist;
    }

    /**
     * Checks whether the user requires a login before being able to use the site
     *
     * @return boolean True when the site requires a login
     */
    public function requiresLogin()
    {
        return $this->username && !$this->isloggedIn();
    }

    /**
     * Checks whether the user is logged in
     *
     * @return boolean True when the user is logged in
     */
    public function isLoggedIn()
    {
        return $this->sessionStorage->isKeyValid('user');
    }

    /**
     * Tries to log the user in
     *
     * @param string $username The user supplied username
     * @param string $password The user supplied password
     * @param string $ip       The IP of the user
     *
     * @return boolean True when the user successfully authenticated
     */
    public function login($username, $password, $ip)
    {
        if (!$this->whitelist->isAllowed($ip)) {
            return false;
        }

        if (strtolower($username) === $this->username && password_verify($password, $this->password)) {
            $this->sessionStorage->set('user', $this->username);

            return true;
        }

        return false;
    }
}
