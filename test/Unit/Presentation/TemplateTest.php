<?php

namespace OpCacheGUITest\Unit\Presentation;

use PHPUnit\Framework\TestCase;

use OpCacheGUITest\Mocks\Presentation\TemplateMock;
use OpCacheGUI\I18n\Translator;
use OpCacheGUI\Presentation\Renderer;

class TemplateTest extends TestCase
{
    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     */
    public function testConstructCorrectInterface()
    {
        $template = new TemplateMock(__DIR__, $this->getMockBuilder(Translator::class)->getMock());

        $this->assertInstanceOf(Renderer::class, $template);
    }

    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     * @covers OpCacheGUI\Presentation\Template::__get
     */
    public function testMagicGetExists()
    {
        $template = new TemplateMock(__DIR__, $this->getMockBuilder(Translator::class)->getMock());

        $template->set('foo', 'bar');

        $this->assertSame('bar', $template->foo);
    }

    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     * @covers OpCacheGUI\Presentation\Template::__get
     */
    public function testMagicGetDoesNotExist()
    {
        $template = new TemplateMock(__DIR__, $this->getMockBuilder(Translator::class)->getMock());

        $this->assertNull($template->foo);
    }

    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     * @covers OpCacheGUI\Presentation\Template::__isset
     */
    public function testMagicIssetExists()
    {
        $template = new TemplateMock(__DIR__, $this->getMockBuilder(Translator::class)->getMock());

        $template->set('foo', 'bar');

        $this->assertTrue(isset($template->foo));
    }

    /**
     * @covers OpCacheGUI\Presentation\Template::__construct
     * @covers OpCacheGUI\Presentation\Template::__isset
     */
    public function testMagicIssetDoesNotExist()
    {
        $template = new TemplateMock(__DIR__, $this->getMockBuilder(Translator::class)->getMock());

        $this->assertFalse(isset($template->foo));
    }
}
