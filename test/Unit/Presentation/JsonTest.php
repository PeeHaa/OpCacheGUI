<?php

namespace OpCacheGUITest\Unit\Presentation;

use PHPUnit\Framework\TestCase;

use OpCacheGUI\Presentation\Json;
use OpCacheGUI\I18n\Translator;
use OpCacheGUI\Presentation\Renderer;
use OpCacheGUI\Presentation\Template;

class JsonTest extends TestCase
{
    /**
     * @covers OpCacheGUI\Presentation\Json::__construct
     */
    public function testConstructCorrectInterface()
    {
        $json = new Json(__DIR__, $this->getMockBuilder(Translator::class)->getMock());

        $this->assertInstanceOf(Renderer::class, $json);
    }

    /**
     * @covers OpCacheGUI\Presentation\Json::__construct
     */
    public function testConstructCorrectInstance()
    {
        $json = new Json(__DIR__, $this->getMockBuilder(Translator::class)->getMock());

        $this->assertInstanceOf(Template::class, $json);
    }

    /**
     * @covers OpCacheGUI\Presentation\Json::__construct
     * @covers OpCacheGUI\Presentation\Json::render
     */
    public function testRender()
    {
        $json = new Json(__DIR__ . '/../../Data/templates', $this->getMockBuilder(Translator::class)->getMock());

        $this->assertSame('content', $json->render('example.pjson'));
    }
}
