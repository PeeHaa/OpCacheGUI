<?php
/**
 * Generates a random string using mt_rand()
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
 * Generates a random string using mt_rand()
 *
 * @category   OpCacheGUI
 * @package    Security
 * @subpackage Generator
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class MtRand implements Generator
{
    /**
     * Generates a random string
     *
     * @param int $length The length of the random string to be generated
     *
     * @return string The generated token
     */
    public function generate($length)
    {
        $buffer = '';

        for ($i = 0; $i < $length; $i++) {
            $buffer .= chr(mt_rand(0, 255));
        }

        return $buffer;
    }
}
