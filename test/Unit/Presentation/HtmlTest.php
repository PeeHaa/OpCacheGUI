<?php

namespace OpCacheGUITest\Unit\Presentation;

use OpCacheGUI\Presentation\Html;

class HtmlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Presentation\Html::__construct
     */
    public function testConstructCorrectInterface()
    {
        $html = new Html(
            __DIR__,
            'page.phtml',
            $this->getMock('\\OpCacheGUI\\I18n\\Translator'),
            $this->getMock('\\OpCacheGUI\\Presentation\\UrlRenderer')
        );

        $this->assertInstanceOf('\\OpCacheGUI\\Presentation\\Renderer', $html);
    }

    /**
     * @covers OpCacheGUI\Presentation\Html::__construct
     */
    public function testConstructCorrectInstance()
    {
        $html = new Html(
            __DIR__,
            'page.phtml',
            $this->getMock('\\OpCacheGUI\\I18n\\Translator'),
            $this->getMock('\\OpCacheGUI\\Presentation\\UrlRenderer')
        );

        $this->assertInstanceOf('\\OpCacheGUI\\Presentation\\Template', $html);
    }

    /**
     * @covers OpCacheGUI\Presentation\Html::__construct
     * @covers OpCacheGUI\Presentation\Html::render
     * @covers OpCacheGUI\Presentation\Html::renderTemplate
     */
    public function testRender()
    {
        $html = new Html(
            __DIR__ . '/../../Data/templates/',
            'skeleton.phtml',
            $this->getMock('\\OpCacheGUI\\I18n\\Translator'),
            $this->getMock('\\OpCacheGUI\\Presentation\\UrlRenderer')
        );

        $this->assertSame('<skeleton>content</skeleton>', $html->render('example.phtml'));
    }
}
