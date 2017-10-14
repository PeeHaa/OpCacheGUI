<?php

namespace OpCacheGUITest\Unit\Presentation;

use OpCacheGUI\I18n\Translator;
use OpCacheGUI\Presentation\Html;
use OpCacheGUI\Presentation\Renderer;
use OpCacheGUI\Presentation\Template;
use OpCacheGUI\Presentation\UrlRenderer;
use PHPUnit\Framework\TestCase;

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
            $this->createMock(Translator::class),
            $this->createMock(UrlRenderer::class)
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
            $this->createMock(Translator::class),
            $this->createMock(UrlRenderer::class)
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
            $this->createMock(Translator::class),
            $this->createMock(UrlRenderer::class)
        );

        $this->assertSame('<skeleton>content</skeleton>', $html->render('example.phtml'));
    }
}
