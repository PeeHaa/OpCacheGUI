<?php

namespace OpCacheGUITest\Mocks\Security\Generator;

use OpCacheGUI\Security\Generator as SecurityGenerator;
use OpCacheGUI\Security\Generator\UnsupportedAlgorithmException;

class Unsupported implements SecurityGenerator
{
    public function __construct()
    {
        throw new UnsupportedAlgorithmException('not supported');
    }

    /**
     * Generates a random string
     *
     * @param int $length The length of the random string to be generated
     */
    public function generate($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
}
