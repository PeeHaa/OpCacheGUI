<?php
/**
 * Generates a random string using openssl
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Security
 * @subpackage Generator
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2014 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Security\Generator;

use OpCacheGUI\Security\Generator;

/**
 * Generates a random string using openssl
 *
 * @category   OpCacheGUI
 * @package    Security
 * @subpackage Generator
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class OpenSsl implements Generator
{
    /**
     * Creates instance
     *
     * @throws \OpCacheGUI\Security\Generator\UnsupportedAlgorithmException When openssl is not installed
     */
    public function __construct()
    {
        if (!function_exists('openssl_random_pseudo_bytes')) {
            throw new UnsupportedAlgorithmException('Openssl isn\'t installed on the system.');
        }
    }

    /**
     * Generates a random string
     *
     * @param int $length The length of the random string to be generated
     *
     * @return string The generated token
     */
    public function generate($length)
    {
        return openssl_random_pseudo_bytes($length);
    }
}
