<?php

namespace OpCacheGUITest\Unit\Network;

use OpCacheGUI\Network\Route;
use OpCacheGUI\Network\RouteBuilder;
use OpCacheGUI\Network\RouteFactory;
use PHPUnit\Framework\TestCase;

class RouteFactoryTest extends TestCase
{
    /**
     */
    public function testConstructCorrectInstance()
    {
        $factory = new RouteFactory;

        $this->assertInstanceOf(RouteBuilder::class, $factory);
    }

    /**
     * @covers OpCacheGUI\Network\RouteFactory::build
     */
    public function testBuild()
    {
        $factory = new RouteFactory;

        $this->assertInstanceOf(Route::class, $factory->build('id', 'GET', function () {}));
    }
}
