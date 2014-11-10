<?php
/**
 * Interface for string trimmers
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Format
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2014 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Format;

/**
 * Interface for string trimmers
 *
 * @category   OpCacheGUI
 * @package    Format
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Trimmer
{
    /**
     * Trims the common prefix from an array of strings
     *
     * @param array $scripts The list of scripts
     *
     * @return array The trimmed strings
     */
    public function trim(array $scripts);
}
