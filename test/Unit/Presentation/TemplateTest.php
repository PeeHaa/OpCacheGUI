<?php

namespace OpCacheGUITest\Unit\Presentation;

use OpCacheGUITest\Mocks\Presentation\TemplateMock;

class TemplateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     */
    public function testConstructCorrectInterface()
    {
        $template = new TemplateMock(__DIR__, $this->getMock('\\OpCacheGUI\\I18n\\Translator'));

        $this->assertInstanceOf('\\OpCacheGUI\\Presentation\\Renderer', $template);
    }

    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     * @covers OpCacheGUI\Presentation\Template::__get
     */
    public function testMagicGetExists()
    {
        $template = new TemplateMock(__DIR__, $this->getMock('\\OpCacheGUI\\I18n\\Translator'));

        $template->set('foo', 'bar');

        $this->assertSame('bar', $template->foo);
    }

    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     * @covers OpCacheGUI\Presentation\Template::__get
     */
    public function testMagicGetDoesNotExist()
    {
        $template = new TemplateMock(__DIR__, $this->getMock('\\OpCacheGUI\\I18n\\Translator'));

        $this->assertNull($template->foo);
    }

    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     * @covers OpCacheGUI\Presentation\Template::__isset
     */
    public function testMagicIssetExists()
    {
        $template = new TemplateMock(__DIR__, $this->getMock('\\OpCacheGUI\\I18n\\Translator'));

        $template->set('foo', 'bar');

        $this->assertTrue(isset($template->foo));
    }

    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     * @covers OpCacheGUI\Presentation\Template::__isset
     */
    public function testMagicIssetDoesNotExist()
    {
        $template = new TemplateMock(__DIR__, $this->getMock('\\OpCacheGUI\\I18n\\Translator'));

        $this->assertFalse(isset($template->foo));
    }
}
