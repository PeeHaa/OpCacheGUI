<?php

namespace OpCacheGUITest\Unit\Network;

use OpCacheGUI\Network\RequestData;
use OpCacheGUI\Network\Route;
use OpCacheGUI\Network\RouteBuilder;
use OpCacheGUI\Network\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @covers OpCacheGUI\Network\Router::__construct
     * @covers OpCacheGUI\Network\Router::post
     * @covers OpCacheGUI\Network\Router::run
     * @covers OpCacheGUI\Network\Router::getIdentifier
     */
    public function testPost()
    {
        $requestMock = $this->createMock(RequestData::class);
        $requestMock->method('getVerb')->willReturn('POST');
        $requestMock->method('path')->willReturn('somepath');

        $routeMock = $this->getMockBuilder(Route::class)->disableOriginalConstructor()->getMock();
        $routeMock->method('matchesRequest')->willReturn(true);
        $routeMock->method('run')->willReturn('foo');

        $factoryMock = $this->createMock(RouteBuilder::class);
        $factoryMock->method('build')->willReturn($routeMock);

        $router = new Router($requestMock, $factoryMock);
        $router->post('id', function () {});

        $this->assertSame('foo', $router->run());
    }

    /**
     * @covers OpCacheGUI\Network\Router::__construct
     * @covers OpCacheGUI\Network\Router::get
     * @covers OpCacheGUI\Network\Router::run
     * @covers OpCacheGUI\Network\Router::getIdentifier
     */
    public function testGet()
    {
        $requestMock = $this->createMock(RequestData::class);
        $requestMock->method('getVerb')->willReturn('GET');
        $requestMock->method('path')->willReturn('somepath');

        $routeMock = $this->getMockBuilder(Route::class)->disableOriginalConstructor()->getMock();
        $routeMock->method('matchesRequest')->willReturn(true);
        $routeMock->method('run')->willReturn('foo');

        $factoryMock = $this->createMock(RouteBuilder::class);
        $factoryMock->method('build')->willReturn($routeMock);

        $router = new Router($requestMock, $factoryMock);
        $router->get('id', function () {});

        $this->assertSame('foo', $router->run());
    }

    /**
     * @covers OpCacheGUI\Network\Router::__construct
     * @covers OpCacheGUI\Network\Router::run
     * @covers OpCacheGUI\Network\Router::getMainPage
     */
    public function testRunNoRoutes()
    {
        $requestMock = $this->createMock(RequestData::class);
        $requestMock->method('getVerb')->willReturn('GET');
        $requestMock->method('path')->willReturn('somepath');

        //$routeMock = $this->getMockBuilder(Route::class)->disableOriginalConstructor()->getMock();
        //$routeMock->method('matchesRequest')->will($this->onConsecutiveCalls(false, true));
        //$routeMock->method('run')->willReturn('main route');

        $factoryMock = $this->createMock(RouteBuilder::class);
        //$factoryMock->method('build')->willReturn($routeMock);

        $router = new Router($requestMock, $factoryMock);
        //$router->get('id', function () {});

        $this->assertNull($router->run());
    }

    /**
     * @covers OpCacheGUI\Network\Router::__construct
     * @covers OpCacheGUI\Network\Router::run
     * @covers OpCacheGUI\Network\Router::getMainPage
     */
    public function testRunNoMatchFirstMatchMain()
    {
        $requestMock = $this->createMock(RequestData::class);
        $requestMock->method('getVerb')->willReturn('GET');
        $requestMock->method('path')->willReturn('somepath');

        $routeMock = $this->getMockBuilder(Route::class)->disableOriginalConstructor()->getMock();
        $routeMock->method('matchesRequest')->will($this->onConsecutiveCalls(false, true));
        $routeMock->method('run')->willReturn('main route');

        $factoryMock = $this->createMock(RouteBuilder::class);
        $factoryMock->method('build')->willReturn($routeMock);

        $router = new Router($requestMock, $factoryMock);
        $router->get('id', function () {});

        $this->assertSame('main route', $router->run());
    }

    /**
     * @covers OpCacheGUI\Network\Router::__construct
     * @covers OpCacheGUI\Network\Router::run
     * @covers OpCacheGUI\Network\Router::getMainPage
     */
    public function testRunNoMatchSecondMatchMain()
    {
        $requestMock = $this->createMock(RequestData::class);
        $requestMock->method('getVerb')->willReturn('GET');
        $requestMock->method('path')->willReturn('somepath');

        $routeMock = $this->getMockBuilder(Route::class)->disableOriginalConstructor()->getMock();
        $routeMock->method('matchesRequest')->will($this->onConsecutiveCalls(false, false, false, true));
        $routeMock->method('run')->willReturn('main route');

        $factoryMock = $this->createMock(RouteBuilder::class);
        $factoryMock->method('build')->willReturn($routeMock);

        $router = new Router($requestMock, $factoryMock);
        $router->get('id', function () {});
        $router->post('id', function () {});

        $this->assertSame('main route', $router->run());
    }

    /**
     * @covers OpCacheGUI\Network\Router::__construct
     * @covers OpCacheGUI\Network\Router::post
     * @covers OpCacheGUI\Network\Router::run
     * @covers OpCacheGUI\Network\Router::getIdentifier
     */
    public function testRunMatchesFirst()
    {
        $requestMock = $this->createMock(RequestData::class);
        $requestMock->method('getVerb')->willReturn('POST');
        $requestMock->method('path')->willReturn('somepath');

        $routeMockMatch = $this->getMockBuilder(Route::class)->disableOriginalConstructor()->getMock();
        $routeMockMatch->method('matchesRequest')->willReturn(true);
        $routeMockMatch->method('run')->willReturn('match');

        $routeMockNoMatch = $this->getMockBuilder(Route::class)->disableOriginalConstructor()->getMock();
        $routeMockNoMatch->method('matchesRequest')->willReturn(false);
        $routeMockNoMatch->method('run')->willReturn('nomatch');

        $factoryMock = $this->createMock(RouteBuilder::class);
        $factoryMock->method('build')->will($this->onConsecutiveCalls($routeMockMatch, $routeMockNoMatch));

        $router = new Router($requestMock, $factoryMock);
        $router->post('id', function () {});

        $this->assertSame('match', $router->run());
    }

    /**
     * @covers OpCacheGUI\Network\Router::__construct
     * @covers OpCacheGUI\Network\Router::post
     * @covers OpCacheGUI\Network\Router::run
     * @covers OpCacheGUI\Network\Router::getIdentifier
     */
    public function testRunMatchesLast()
    {
        $requestMock = $this->createMock(RequestData::class);
        $requestMock->method('getVerb')->willReturn('POST');
        $requestMock->method('path')->willReturn('somepath');

        $routeMockMatch = $this->getMockBuilder(Route::class)->disableOriginalConstructor()->getMock();
        $routeMockMatch->method('matchesRequest')->willReturn(true);
        $routeMockMatch->method('run')->willReturn('match');

        $routeMockNoMatch = $this->getMockBuilder(Route::class)->disableOriginalConstructor()->getMock();
        $routeMockNoMatch->method('matchesRequest')->willReturn(false);
        $routeMockNoMatch->method('run')->willReturn('nomatch');

        $factoryMock = $this->createMock(RouteBuilder::class);
        $factoryMock->method('build')->will($this->onConsecutiveCalls($routeMockNoMatch, $routeMockMatch));

        $router = new Router($requestMock, $factoryMock);
        $router->post('id', function () {});
        $router->post('id', function () {});

        $this->assertSame('match', $router->run());
    }

    /**
     * @covers OpCacheGUI\Network\Router::__construct
     * @covers OpCacheGUI\Network\Router::getIdentifier
     */
    public function testIdentifierWithImplicitUrlRewrite()
    {
        $requestMock = $this->createMock(RequestData::class);
        $requestMock->method('path')->willReturn('somepath');

        $factoryMock = $this->createMock(RouteBuilder::class);

        $router = new Router($requestMock, $factoryMock);

        $this->assertSame('somepath', $router->getIdentifier());
    }

    /**
     * @covers OpCacheGUI\Network\Router::__construct
     * @covers OpCacheGUI\Network\Router::getIdentifier
     */
    public function testIdentifierWithExplicitUrlRewrite()
    {
        $requestMock = $this->createMock(RequestData::class);
        $requestMock->method('path')->willReturn('somepath');

        $factoryMock = $this->createMock(RouteBuilder::class);

        $router = new Router($requestMock, $factoryMock, Router::URL_REWRITE);

        $this->assertSame('somepath', $router->getIdentifier());
    }

    /**
     * @covers OpCacheGUI\Network\Router::__construct
     * @covers OpCacheGUI\Network\Router::getIdentifier
     */
    public function testIdentifierWithQueryString()
    {
        $requestMock = $this->createMock(RequestData::class);
        $requestMock->method('get')->willReturn('somepath');

        $factoryMock = $this->createMock(RouteBuilder::class);

        $router = new Router($requestMock, $factoryMock, Router::QUERY_STRING);

        $this->assertSame('somepath', $router->getIdentifier());
    }
}
