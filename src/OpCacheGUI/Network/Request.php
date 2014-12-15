<?php
/**
 * Simple request class
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
 * Simple request class
 *
 * @category   OpCacheGUI
 * @package    Network
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Request implements RequestData
{
    /**
     * @var array The get variables
     */
    private $getVariables = [];

    /**
     * @var array The post variables
     */
    private $postVariables = [];

    /**
     * @var array The server variables
     */
    private $serverVariables = [];

    /**
     * @var array The path variables
     */
    private $pathVariables = [];

    /**
     * Creates instance
     *
     * @param array $get    The get variables
     * @param array $post   The post variables
     * @param array $server The server variables
     */
    public function __construct(array $get, array $post, array $server)
    {
        $this->getVariables    = $get;
        $this->postVariables   = $post;
        $this->serverVariables = $server;
        $this->pathVariables   = explode('/', trim($server['REQUEST_URI'], '/'));
    }

    /**
     * Gets the variable or returns false when it does not exists
     *
     * @return string The value of the get param or false when it does not exist
     */
    public function get()
    {
        if (!$this->getVariables) {
            return '';
        }

        $queryStringParams = array_keys($this->getVariables);

        return reset($queryStringParams);
    }

    /**
     * Gets the variable
     *
     * @return string The value of the path param
     */
    public function path()
    {
        return end($this->pathVariables);
    }

    /**
     * Gets the verb of the request
     *
     * @return string The verb used by the request
     */
    public function getVerb()
    {
        return $this->serverVariables['REQUEST_METHOD'];
    }

    /**
     * Gets a post variable
     *
     * @param string $name The name of the post variable to get
     *
     * @return mixed The value
     */
    public function post($name)
    {
        return $this->postVariables[$name];
    }

    /**
     * Gets the current URL
     *
     * @return string The current URL
     */
    public function getUrl()
    {
        $scheme = 'http';

        if (isset($this->serverVariables['HTTPS']) && $this->serverVariables['HTTPS'] === 'on') {
            $scheme .= 's';
        }

        return $scheme . '://' . $this->serverVariables['HTTP_HOST'] . $this->serverVariables['REQUEST_URI'];
    }

    /**
     * Gets the user's IP address
     *
     * @return string The IP of the user
     */
    public function getIp()
    {
        return $this->serverVariables['REMOTE_ADDR'];
    }
}
