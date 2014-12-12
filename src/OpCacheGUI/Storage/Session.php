<?php
/**
 * Session class
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Storage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2014 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Storage;

/**
 * Session class
 *
 * @category   OpCacheGUI
 * @package    Storage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Session implements KeyValuePair, Regeneratable
{
    /**
     * Sets the value
     *
     * @param string $key   The key in which to store the value
     * @param mixed  $value The value to store
     *
     * @return void
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Gets a value from the session superglobal
     *
     * @param string $key The key of which to retrieve the value
     *
     * @return mixed                                   The value
     * @throws \OpCacheGUI\Storage\InvalidKeyException When the key is not found
     */
    public function get($key)
    {
        if (!$this->isKeyValid($key)) {
            throw new InvalidKeyException('Key (`' . $key . '`) not found in session.');
        }

        return $_SESSION[$key];
    }

    /**
     * Check whether the supplied key is valid (i.e. does exist in the session superglobal)
     *
     * @param string $key The key to check
     *
     * @return boolean Whether the supplied key is valid
     */
    public function isKeyValid($key)
    {
        if (array_key_exists($key, $_SESSION)) {
            return true;
        }

        return false;
    }

    /**
     * Regenerates a new session id and initializes the session superglobal
     *
     * @codeCoverageIgnore
     */
    public function regenerate()
    {
        session_regenerate_id(true);
        $_SESSION = [];
    }
}
