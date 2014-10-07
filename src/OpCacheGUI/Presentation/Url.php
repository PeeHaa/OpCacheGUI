<?php
/**
 * Class for rendering urls to be easily able to switch between clean urls and querystrings
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

use OpCacheGUI\Network\Router;

/**
 * Class for rendering urls to be easily able to switch between clean urls and querystrings
 *
 * @category   OpCacheGUI
 * @package    Presentation
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Url implements UrlRenderer
{
    /**
     * private int The type of the URIs
     */
    private $type;

    /**
     * Creates instance
     *
     * @param int $type The type of the URIs
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Gets the URI based on the type
     *
     * @param string $identifier The identifier used for which to get the URI
     *
     * @return string The URI
     */
    public function get($identifier)
    {
        if ($this->type === Router::URL_REWRITE) {
            return $this->getRewriteUrl($identifier);
        }

        return $this->getQueryStringUrl($identifier);
    }

    /**
     * Gets the URI based on the rewrite scheme
     *
     * @param string $identifier The identifier used for which to get the URI
     *
     * @return string The URI
     */
    private function getRewriteUrl($identifier)
    {
        if ($identifier === 'status') {
            return '..';
        }

        return '/' . $identifier;
    }

    /**
     * Gets the URI based on query strings
     *
     * @param string $identifier The identifier used for which to get the URI
     *
     * @return string The URI
     */
    private function getQueryStringUrl($identifier)
    {
        if ($identifier === 'status') {
            return '?';
        }

        return '?' . $identifier;
    }
}
