<?php
/**
 * Generates a random string using mcrypt
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
namespace OpCacheGUI\Security;

/**
 * Generates a random string using mcrypt
 *
 * @category   OpCacheGUI
 * @package    Security
 * @subpackage Generator
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Generator
{
    /**
     * Generates a random string
     *
     * @param int $length The length of the random string to be generated
     *
     * @return string The generated token
     */
    public function generate($length);
}
