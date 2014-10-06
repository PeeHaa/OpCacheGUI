<?php
/**
 * Interface for translators
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    I18n
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\I18n;

/**
 * Interface for translators
 *
 * @category   OpCacheGUI
 * @package    I18n
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Translator
{
    /**
     * Gets the translation by key if any or a placeholder otherwise
     *
     * @param string $key The translation key for which to find the translation
     *
     * @return string The translation or a placeholder when no translation is available
     */
    public function translate($key);
}
