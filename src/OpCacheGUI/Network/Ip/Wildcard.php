<?php
/**
 * IP range converter for a wildcard IP address
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Network
 * @subpackage Ip
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2014 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Network\Ip;

/**
 * IP range converter for a wildcard IP address
 *
 * @category   OpCacheGUI
 * @package    Network
 * @subpackage Ip
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Wildcard implements Converter
{
    /**
     * Checks whether is certain address is valid for the converter implementation
     *
     * @param string $address The address to check
     *
     * @return boolean True when the address is valid
     */
    public function isValid($address)
    {
        if (!preg_match('/^\d+\.(\d+|\*)\.(\d+|\*)\.(\d+|\*)$/', $address)) {
            return false;
        }

        return substr_count($address, '*') > 0 && substr_count($address, '*') < 4;
    }

    /**
     * Converts an IP address or range into a range to easily check for access
     *
     * @param string $address The IP address / range
     *
     * @return double[] Array containing the first and last ip in the range
     */
    public function convert($address)
    {
        return [
            (float) sprintf('%u', ip2long(str_replace('*', '0', $address))),
            (float) sprintf('%u', ip2long(str_replace('*', '255', $address))),
        ];
    }
}
