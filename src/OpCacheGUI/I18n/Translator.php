<?php
/**
 * Translator based on translation files containing an array with texts
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
 * Translator based on translation files containing an array with texts
 *
 * @category   OpCacheGUI
 * @package    I18n
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Translator
{
    /**
     * @var array The translations
     */
    private $texts;

    /**
     * Creates instance
     *
     * @param string $languageCode The language code of which to get the translations
     *
     * @throws \Exception When the language is not supported (i.e. no translation file can be found for the language)
     * @throws \Exception When the translation file is invalid (i.e. no `$texts` array present)
     */
    public function __construct($languageCode)
    {
        $translationFile = __DIR__ . '/../../../texts/' . $languageCode . '.php';

        if (!file_exists($translationFile)) {
            throw new \Exception('Unsupported language (`' . $languageCode . '`).');
        }

        require $translationFile;

        if (!isset($texts)) {
            throw new \Exception(
                'The translation file (`' . $translationFile . '`) has an invalid format.'
            );
        }

        $this->texts = $texts;
    }

    /**
     * Gets the translation by key if any or a placeholder otherwise
     *
     * @param string $key The translation key for which to find the translation
     *
     * @return string The translation or a placeholder when no translation is available
     */
    public function translate($key)
    {
        if (array_key_exists($key, $this->texts)) {
            return $this->texts[$key];
        }

        return '{{' . $key . '}}';
    }
}
