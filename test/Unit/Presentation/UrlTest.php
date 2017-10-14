<?php

namespace OpCacheGUITest\Unit\Presentation;

use PHPUnit\Framework\TestCase;

use OpCacheGUI\Presentation\Url;
use OpCacheGUI\Network\Router;
use OpCacheGUI\Presentation\UrlRenderer;

class UrlTest extends TestCase
{
    /**
     * @covers OpCacheGUI\Presentation\Url::__construct
     */
    public function testConstructCorrectInterface()
    {
        $url = new Url(Router::URL_REWRITE);

        $this->assertInstanceOf(UrlRenderer::class, $url);
    }

    /**
     * @covers OpCacheGUI\Presentation\Url::__construct
     * @covers OpCacheGUI\Presentation\Url::get
     * @covers OpCacheGUI\Presentation\Url::getRewriteUrl
     */
    public function testGetRewriteUrlStatus()
    {
        $url = new Url(Router::URL_REWRITE);

        $this->assertSame('..', $url->get('status'));
    }

    /**
     * @covers OpCacheGUI\Presentation\Url::__construct
     * @covers OpCacheGUI\Presentation\Url::get
     * @covers OpCacheGUI\Presentation\Url::getRewriteUrl
     */
    public function testGetRewriteUrlOther()
    {
        $url = new Url(Router::URL_REWRITE);

        $this->assertSame('/other', $url->get('other'));
    }

    /**
     * @covers OpCacheGUI\Presentation\Url::__construct
     * @covers OpCacheGUI\Presentation\Url::get
     * @covers OpCacheGUI\Presentation\Url::getQueryStringUrl
     */
    public function testGetQueryStringUrlStatus()
    {
        $url = new Url(Router::QUERY_STRING);

        $this->assertSame('?', $url->get('status'));
    }

    /**
     * @covers OpCacheGUI\Presentation\Url::__construct
     * @covers OpCacheGUI\Presentation\Url::get
     * @covers OpCacheGUI\Presentation\Url::getQueryStringUrl
     */
    public function testGetQueryStringUrlOther()
    {
        $url = new Url(Router::QUERY_STRING);

        $this->assertSame('?other', $url->get('other'));
    }
}
