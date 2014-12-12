<?php
/**
 * IP range converter for a localhost loopback address
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
 * IP range converter for a localhost loopback address
 *
 * @category   OpCacheGUI
 * @package    Network
 * @subpackage Ip
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Localhost extends Single
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
        return $address === 'localhost';
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
        return parent::convert('127.0.0.1');
    }
}
