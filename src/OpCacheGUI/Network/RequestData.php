<?php
/**
 * Interface for request classes
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Network
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2014 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Network;

/**
 * Interface for request classes
 *
 * @category   OpCacheGUI
 * @package    Network
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface RequestData
{
    /**
     * Gets the variable or returns false when it does not exists
     *
     * @return boolean|string The value of the get param or false when it does not exist
     */
    public function get();

    /**
     * Gets the variable
     *
     * @return string The value of the path param
     */
    public function path();

    /**
     * Gets the verb of the request
     *
     * @return string The verb used by the request
     */
    public function getVerb();

    /**
     * Gets a post variable
     *
     * @param string $name The name of the post variable to get
     *
     * @return mixed The value
     */
    public function post($name);

    /**
     * Gets the current URL
     *
     * @return string The current URL
     */
    public function getUrl();

    /**
     * Gets the user's IP address
     *
     * @return string The IP of the user
     */
    public function getIp();
}
