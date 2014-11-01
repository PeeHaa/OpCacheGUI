<?php

namespace OpCacheGUITest\Unit\Network\Ip;

use OpCacheGUI\Network\Ip\Localhost;

class LocalhostTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testConstructCorrectInstance()
    {
        $ipRange = new Localhost();

        $this->assertInstanceOf('\\OpCacheGUI\\Network\\Ip\\Converter', $ipRange);
    }

    /**
     */
    public function testConstructCorrectParent()
    {
        $ipRange = new Localhost();

        $this->assertInstanceOf('\\OpCacheGUI\\Network\\Ip\\Single', $ipRange);
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Single::convert
     */
    public function testConvert()
    {
        $ipRange = new Localhost();

        $this->assertSame([2130706433.0, 2130706433.0], $ipRange->convert('localhost'));
    }
}
