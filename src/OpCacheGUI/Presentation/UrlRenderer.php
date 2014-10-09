<?php
/**
 * Interface for URI renderers
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Presentation
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2014 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Presentation;

/**
 * Interface for URI renderers
 *
 * @category   OpCacheGUI
 * @package    Presentation
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface UrlRenderer
{
    /**
     * Gets the URI based on the type
     *
     * @param string $identifier The identifier used for which to get the URI
     *
     * @return string The URI
     */
    public function get($identifier);
}
