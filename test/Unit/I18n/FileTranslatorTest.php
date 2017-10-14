<?php

namespace OpCacheGUITest\Unit\I18n;

use OpCacheGUI\I18n\FileTranslator;
use OpCacheGUI\I18n\Translator;
use PHPUnit\Framework\TestCase;

class FileTranslatorTest extends TestCase
{
    /**
     * @covers OpCacheGUI\I18n\FileTranslator::__construct
     */
    public function testConstructCorrectInstance()
    {
        $translator = new FileTranslator(__DIR__ . '/../../Data/texts', 'en');

        $this->assertInstanceOf(Translator::class, $translator);
    }

    /**
     * @covers OpCacheGUI\I18n\FileTranslator::__construct
     */
    public function testConstructThrowsUpOnUnsupportedLanguage()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unsupported language (`abcdef`).');

        new FileTranslator(__DIR__ . '/../../Data/texts', 'abcdef');
    }

    /**
     * @covers OpCacheGUI\I18n\FileTranslator::__construct
     */
    public function testConstructThrowsUpOnInvalidTranslationFile()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('The translation file (`' . __DIR__ . '/../../Data/texts/invalid.php`) has an invalid format.');

        new FileTranslator(__DIR__ . '/../../Data/texts', 'invalid');
    }

    /**
     * @covers OpCacheGUI\I18n\FileTranslator::__construct
     * @covers OpCacheGUI\I18n\FileTranslator::translate
     */
    public function testTranslateWIthInvalidKey()
    {
        $translator = new FileTranslator(__DIR__ . '/../../Data/texts', 'en');

        $this->assertSame('{{invalidkey}}', $translator->translate('invalidkey'));
    }

    /**
     * @covers OpCacheGUI\I18n\FileTranslator::__construct
     * @covers OpCacheGUI\I18n\FileTranslator::translate
     */
    public function testTranslateWIthValidKey()
    {
        $translator = new FileTranslator(__DIR__ . '/../../Data/texts', 'en');

        $this->assertSame('bar', $translator->translate('foo'));
    }
}
