<?php

namespace OpCacheGUITest\Unit\Network;

use OpCacheGUI\Network\RouteFactory;

class RouteFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testConstructCorrectInstance()
    {
        $factory = new RouteFactory;

        $this->assertInstanceOf('\\OpCacheGUI\\Network\\RouteBuilder', $factory);
    }

    /**
     * @covers OpCacheGUI\Network\RouteFactory::build
     */
    public function testBuild()
    {
        $factory = new RouteFactory;

        $this->assertInstanceOf('\\OpCacheGUI\\Network\\Route', $factory->build('id', 'GET', function () {}));
    }
}
