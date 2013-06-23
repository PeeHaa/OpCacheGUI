<?php
/**
 * Formatter for byte values
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Format
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Format;

/**
 * Formatter for byte values
 *
 * @category   OpCacheGUI
 * @package    Format
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Byte
{
    /**
     * Formats size to byte units
     *
     * @param int $size     The size in bytes
     * @param int $decimals The number of decimals
     *
     * return $string The formatted bytes
     */
    public function format($size, $decimals = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $position = 0;

        do {
            if ($size < 1024) {
                return round($size, $decimals) . $units[$position];
            }

            $size = $size / 1024;
            $position++;
        } while ($position < count($units));

        return round($size, $decimals) . end($units);
    }
}
