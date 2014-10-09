<?php
/**
 * This class represents a single endpoint
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
 * This class represents a single endpoint
 *
 * @category   OpCacheGUI
 * @package    Network
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Route
{
    /**
     * @var string The identifier of this route
     */
    private $identifier;

    /**
     * @var string The verb of this route
     */
    private $verb;

    /**
     * @var callable The callback to execute when this route matches
     */
    private $callback;

    /**
     * Creates instance
     *
     * @param string   $identifier The identifier of this route
     * @param string   $verb       The verb of this route
     * @param callable $callback   The callback to execute when this route matches
     */
    public function __construct($identifier, $verb, callable $callback)
    {
        $this->identifier = $identifier;
        $this->verb       = $verb;
        $this->callback   = $callback;
    }

    /**
     * Checks whether the current request matches the route
     *
     * @param string $identifier The identifier of this route
     * @param string $verb       The verb of this route
     */
    public function matchesRequest($identifier, $verb)
    {
        return $this->identifier === $identifier && $this->verb === $verb;
    }

    /**
     * Runs the route
     *
     * @return mixed The result of the callback
     */
    public function run()
    {
        $callback = $this->callback;

        return $callback();
    }
}
