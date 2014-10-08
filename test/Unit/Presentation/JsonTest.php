<?php

namespace OpCacheGUITest\Unit\Presentation;

use OpCacheGUI\Presentation\Json;

class JsonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Presentation\Json::__construct
     */
    public function testConstructCorrectInterface()
    {
        $json = new Json(__DIR__, $this->getMock('\\OpCacheGUI\\I18n\\Translator'));

        $this->assertInstanceOf('\\OpCacheGUI\\Presentation\\Renderer', $json);
    }

    /**
     * @covers OpCacheGUI\Presentation\Json::__construct
     */
    public function testConstructCorrectInstance()
    {
        $json = new Json(__DIR__, $this->getMock('\\OpCacheGUI\\I18n\\Translator'));

        $this->assertInstanceOf('\\OpCacheGUI\\Presentation\\Template', $json);
    }

    /**
     * @covers OpCacheGUI\Presentation\Json::__construct
     * @covers OpCacheGUI\Presentation\Json::render
     */
    public function testRender()
    {
        $json = new Json(__DIR__ . '/../../Data/templates', $this->getMock('\\OpCacheGUI\\I18n\\Translator'));

        $this->assertSame('content', $json->render('example.pjson'));
    }
}
