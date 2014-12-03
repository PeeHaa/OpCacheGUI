<?php

namespace OpCacheGUITest\Unit\Network;

use OpCacheGUI\Network\Router;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Network\Router::__construct
     * @covers OpCacheGUI\Network\Router::post
     * @covers OpCacheGUI\Network\Router::run
     * @covers OpCacheGUI\Network\Router::getIdentifier
     */
    public function testPost()
    {
        $requestMock = $this->getMock('\\OpCacheGUI\\Network\\RequestData');
        $requestMock->method('getVerb')->willReturn('POST');
        $requestMock->method('path')->willReturn('somepath');

        $routeMock = $this->getMockBuilder('\\OpCacheGUI\\Network\\Route')->disableOriginalConstructor()->getMock();
        $routeMock->method('matchesRequest')->willReturn(true);
        $routeMock->method('run')->willReturn('foo');

        $factoryMock = $this->getMock('\\OpCacheGUI\\Network\\RouteBuilder');
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
        $requestMock = $this->getMock('\\OpCacheGUI\\Network\\RequestData');
        $requestMock->method('getVerb')->willReturn('GET');
        $requestMock->method('path')->willReturn('somepath');

        $routeMock = $this->getMockBuilder('\\OpCacheGUI\\Network\\Route')->disableOriginalConstructor()->getMock();
        $routeMock->method('matchesRequest')->willReturn(true);
        $routeMock->method('run')->willReturn('foo');

        $factoryMock = $this->getMock('\\OpCacheGUI\\Network\\RouteBuilder');
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
        $requestMock = $this->getMock('\\OpCacheGUI\\Network\\RequestData');
        $requestMock->method('getVerb')->willReturn('GET');
        $requestMock->method('path')->willReturn('somepath');

        //$routeMock = $this->getMockBuilder('\\OpCacheGUI\\Network\\Route')->disableOriginalConstructor()->getMock();
        //$routeMock->method('matchesRequest')->will($this->onConsecutiveCalls(false, true));
        //$routeMock->method('run')->willReturn('main route');

        $factoryMock = $this->getMock('\\OpCacheGUI\\Network\\RouteBuilder');
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
        $requestMock = $this->getMock('\\OpCacheGUI\\Network\\RequestData');
        $requestMock->method('getVerb')->willReturn('GET');
        $requestMock->method('path')->willReturn('somepath');

        $routeMock = $this->getMockBuilder('\\OpCacheGUI\\Network\\Route')->disableOriginalConstructor()->getMock();
        $routeMock->method('matchesRequest')->will($this->onConsecutiveCalls(false, true));
        $routeMock->method('run')->willReturn('main route');

        $factoryMock = $this->getMock('\\OpCacheGUI\\Network\\RouteBuilder');
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
        $requestMock = $this->getMock('\\OpCacheGUI\\Network\\RequestData');
        $requestMock->method('getVerb')->willReturn('GET');
        $requestMock->method('path')->willReturn('somepath');

        $routeMock = $this->getMockBuilder('\\OpCacheGUI\\Network\\Route')->disableOriginalConstructor()->getMock();
        $routeMock->method('matchesRequest')->will($this->onConsecutiveCalls(false, false, false, true));
        $routeMock->method('run')->willReturn('main route');

        $factoryMock = $this->getMock('\\OpCacheGUI\\Network\\RouteBuilder');
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
        $requestMock = $this->getMock('\\OpCacheGUI\\Network\\RequestData');
        $requestMock->method('getVerb')->willReturn('POST');
        $requestMock->method('path')->willReturn('somepath');

        $routeMockMatch = $this->getMockBuilder('\\OpCacheGUI\\Network\\Route')->disableOriginalConstructor()->getMock();
        $routeMockMatch->method('matchesRequest')->willReturn(true);
        $routeMockMatch->method('run')->willReturn('match');

        $routeMockNoMatch = $this->getMockBuilder('\\OpCacheGUI\\Network\\Route')->disableOriginalConstructor()->getMock();
        $routeMockNoMatch->method('matchesRequest')->willReturn(false);
        $routeMockNoMatch->method('run')->willReturn('nomatch');

        $factoryMock = $this->getMock('\\OpCacheGUI\\Network\\RouteBuilder');
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
        $requestMock = $this->getMock('\\OpCacheGUI\\Network\\RequestData');
        $requestMock->method('getVerb')->willReturn('POST');
        $requestMock->method('path')->willReturn('somepath');

        $routeMockMatch = $this->getMockBuilder('\\OpCacheGUI\\Network\\Route')->disableOriginalConstructor()->getMock();
        $routeMockMatch->method('matchesRequest')->willReturn(true);
        $routeMockMatch->method('run')->willReturn('match');

        $routeMockNoMatch = $this->getMockBuilder('\\OpCacheGUI\\Network\\Route')->disableOriginalConstructor()->getMock();
        $routeMockNoMatch->method('matchesRequest')->willReturn(false);
        $routeMockNoMatch->method('run')->willReturn('nomatch');

        $factoryMock = $this->getMock('\\OpCacheGUI\\Network\\RouteBuilder');
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
        $requestMock = $this->getMock('\\OpCacheGUI\\Network\\RequestData');
        $requestMock->method('path')->willReturn('somepath');

        $factoryMock = $this->getMock('\\OpCacheGUI\\Network\\RouteBuilder');

        $router = new Router($requestMock, $factoryMock);

        $this->assertSame('somepath', $router->getIdentifier());
    }

    /**
     * @covers OpCacheGUI\Network\Router::__construct
     * @covers OpCacheGUI\Network\Router::getIdentifier
     */
    public function testIdentifierWithExplicitUrlRewrite()
    {
        $requestMock = $this->getMock('\\OpCacheGUI\\Network\\RequestData');
        $requestMock->method('path')->willReturn('somepath');

        $factoryMock = $this->getMock('\\OpCacheGUI\\Network\\RouteBuilder');

        $router = new Router($requestMock, $factoryMock, Router::URL_REWRITE);

        $this->assertSame('somepath', $router->getIdentifier());
    }

    /**
     * @covers OpCacheGUI\Network\Router::__construct
     * @covers OpCacheGUI\Network\Router::getIdentifier
     */
    public function testIdentifierWithQueryString()
    {
        $requestMock = $this->getMock('\\OpCacheGUI\\Network\\RequestData');
        $requestMock->method('get')->willReturn('somepath');

        $factoryMock = $this->getMock('\\OpCacheGUI\\Network\\RouteBuilder');

        $router = new Router($requestMock, $factoryMock, Router::QUERY_STRING);

        $this->assertSame('somepath', $router->getIdentifier());
    }
}
