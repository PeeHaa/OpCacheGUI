<?php
/**
 * Interface for route factories
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
 * Interface for route factories
 *
 * @category   OpCacheGUI
 * @package    Network
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface RouteBuilder
{
    /**
     * Creates the new route
     *
     * @param string   $identifier The identifier of this route
     * @param string   $verb       The verb of this route
     * @param callable $callback   The callback to execute when this route matches
     *
     * @return \OpCacheGUI\Network\Route
     */
    public function build($identifier, $verb, callable $callback);
}
