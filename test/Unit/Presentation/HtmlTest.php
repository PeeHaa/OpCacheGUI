<?php

namespace OpCacheGUITest\Unit\Presentation;

use PHPUnit\Framework\TestCase;

use OpCacheGUI\Presentation\Html;
use OpCacheGUI\I18n\Translator;
use OpCacheGUI\Presentation\UrlRenderer;
use OpCacheGUI\Presentation\Renderer;
use OpCacheGUI\Presentation\Template;

class HtmlTest extends TestCase
{
    /**
     * @covers OpCacheGUI\Presentation\Html::__construct
     */
    public function testConstructCorrectInterface()
    {
        $html = new Html(
            __DIR__,
            'page.phtml',
            $this->getMockBuilder(Translator::class)->getMock(),
            $this->getMockBuilder(UrlRenderer::class)->getMock()
        );

        $this->assertInstanceOf(Renderer::class, $html);
    }

    /**
     * @covers OpCacheGUI\Presentation\Html::__construct
     */
    public function testConstructCorrectInstance()
    {
        $html = new Html(
            __DIR__,
            'page.phtml',
            $this->getMockBuilder(Translator::class)->getMock(),
            $this->getMockBuilder(UrlRenderer::class)->getMock()
        );

        $this->assertInstanceOf(Template::class, $html);
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
            $this->getMockBuilder(Translator::class)->getMock(),
            $this->getMockBuilder(UrlRenderer::class)->getMock()
        );

        $this->assertSame('<skeleton>content</skeleton>', $html->render('example.phtml'));
    }
}
