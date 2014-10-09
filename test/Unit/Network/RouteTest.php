<?php

namespace OpCacheGUITest\Unit\Network;

use OpCacheGUI\Network\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Network\Route::__construct
     * @covers OpCacheGUI\Network\Route::matchesRequest
     */
    public function testMatchesRequestNoMatch()
    {
        $route = new Route('id', 'GET', function () {});

        $this->assertFalse($route->matchesRequest('notid', 'notGET'));
    }

    /**
     * @covers OpCacheGUI\Network\Route::__construct
     * @covers OpCacheGUI\Network\Route::matchesRequest
     */
    public function testMatchesRequestNoMatchIdentifier()
    {
        $route = new Route('id', 'GET', function () {});

        $this->assertFalse($route->matchesRequest('notid', 'GET'));
    }

    /**
     * @covers OpCacheGUI\Network\Route::__construct
     * @covers OpCacheGUI\Network\Route::matchesRequest
     */
    public function testMatchesRequestNoMatchVerb()
    {
        $route = new Route('id', 'GET', function () {});

        $this->assertFalse($route->matchesRequest('id', 'notGET'));
    }

    /**
     * @covers OpCacheGUI\Network\Route::__construct
     * @covers OpCacheGUI\Network\Route::matchesRequest
     */
    public function testMatchesRequestValid()
    {
        $route = new Route('id', 'GET', function () {});

        $this->assertTrue($route->matchesRequest('id', 'GET'));
    }

    /**
     * @covers OpCacheGUI\Network\Route::__construct
     * @covers OpCacheGUI\Network\Route::run
     */
    public function testRun()
    {
        $route = new Route('id', 'GET', function () {
            return 'foo';
        });

        $this->assertSame('foo', $route->run());
    }
}
