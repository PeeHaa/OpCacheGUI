<?php
/**
 * Trims the common prefix from the full_path index of cached scripts
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
 * Trims the common prefix from the full_path index of cached scripts
 *
 * @category   OpCacheGUI
 * @package    Format
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Prefix implements Trimmer
{
    /**
     * Trims the common prefix from an array of strings
     *
     * @param array $scripts The list of scripts
     *
     * @return array The trimmed strings
     */
    public function trim(array $scripts)
    {
        $length = $this->getPrefixLength($scripts);

        foreach ($scripts as $index => $script) {
            $scripts[$index]['full_path'] = mb_substr($script['full_path'], $length);
        }

        return $scripts;
    }

    /**
     * Gets the length of the common prefix to trim
     *
     * @param array $scripts The list of scripts
     *
     * @return int The length of the common prefix
     */
    private function getPrefixLength(array $scripts)
    {
        $prefix = $scripts[0]['full_path'];

        foreach ($scripts as $script) {
            if ($prefix === '') {
                return 0;
            }

            if (strpos($script['full_path'], $prefix) === 0) {
                continue;
            }

            $prefix = $this->findLongestPrefix($prefix, $script['full_path']);
        }

        return mb_strlen($prefix);
    }

    /**
     * Get the longest common prefix between two strings
     *
     * @param string $prefix The current common prefix
     * @param string $path   The path to match against the common prefix
     *
     * @return string The common prefix
     */
    private function findLongestPrefix($prefix, $path)
    {
        $prefixChars = str_split(str_replace('\\', '/', $prefix));
        $pathChars   = str_split(str_replace('\\', '/', $path));

        $lastSlash = 0;

        foreach ($prefixChars as $index => $char) {
            if ($char === '/') {
                $lastSlash = $index;
            }

            if ($char !== $pathChars[$index]) {
                return mb_substr($prefix, 0, $lastSlash);
            }
        }
    }
}
