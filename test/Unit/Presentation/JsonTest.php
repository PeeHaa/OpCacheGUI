<?php

namespace OpCacheGUITest\Unit\Presentation;

use OpCacheGUI\I18n\Translator;
use OpCacheGUI\Presentation\Json;
use OpCacheGUI\Presentation\Renderer;
use OpCacheGUI\Presentation\Template;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
    /**
     * @covers OpCacheGUI\Presentation\Json::__construct
     */
    public function testConstructCorrectInterface()
    {
        $json = new Json(__DIR__, $this->createMock(Translator::class));

        $this->assertInstanceOf(Renderer::class, $json);
    }

    /**
     * @covers OpCacheGUI\Presentation\Json::__construct
     */
    public function testConstructCorrectInstance()
    {
        $json = new Json(__DIR__, $this->createMock(Translator::class));

        $this->assertInstanceOf(Template::class, $json);
    }

    /**
     * @covers OpCacheGUI\Presentation\Json::__construct
     * @covers OpCacheGUI\Presentation\Json::render
     */
    public function testRender()
    {
        $json = new Json(__DIR__ . '/../../Data/templates', $this->createMock(Translator::class));

        $this->assertSame('content', $json->render('example.pjson'));
    }
}
