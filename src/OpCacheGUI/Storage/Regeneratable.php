<?php
/**
 * Interface for class that can regenerate a state id (like sessions)
 *
 * All classes which represent a session should implement this. This is useful for creating a mock session class.
 *
 * PHP version 5.4
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
 * Interface for class that can regenerate a state id (like sessions)
 *
 * @category   OpCacheGUI
 * @package    Storage
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Regeneratable
{
    /**
     * Regenerates a new session id and initializes the session superglobal
     *
     * @return void
     */
    public function regenerate();
}
