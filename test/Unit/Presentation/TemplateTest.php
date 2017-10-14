<?php

namespace OpCacheGUITest\Unit\Presentation;

use OpCacheGUI\I18n\Translator;
use OpCacheGUITest\Mocks\Presentation\TemplateMock;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     */
    public function testConstructCorrectInterface()
    {
        $template = new TemplateMock(__DIR__, $this->createMock(Translator::class));

        $this->assertInstanceOf('\\OpCacheGUI\\Presentation\\Renderer', $template);
    }

    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     * @covers OpCacheGUI\Presentation\Template::__get
     */
    public function testMagicGetExists()
    {
        $template = new TemplateMock(__DIR__, $this->createMock(Translator::class));

        $template->set('foo', 'bar');

        $this->assertSame('bar', $template->foo);
    }

    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     * @covers OpCacheGUI\Presentation\Template::__get
     */
    public function testMagicGetDoesNotExist()
    {
        $template = new TemplateMock(__DIR__, $this->createMock(Translator::class));

        $this->assertNull($template->foo);
    }

    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     * @covers OpCacheGUI\Presentation\Template::__isset
     */
    public function testMagicIssetExists()
    {
        $template = new TemplateMock(__DIR__, $this->createMock(Translator::class));

        $template->set('foo', 'bar');

        $this->assertTrue(isset($template->foo));
    }

    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     * @covers OpCacheGUI\Presentation\Template::__isset
     */
    public function testMagicIssetDoesNotExist()
    {
        $template = new TemplateMock(__DIR__, $this->createMock(Translator::class));

        $this->assertFalse(isset($template->foo));
    }
}
