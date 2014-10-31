<?php

namespace OpCacheGUITest\Unit\Network\Ip;

use OpCacheGUI\Network\Ip\Single;

class SingleTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testConstructCorrectInstance()
    {
        $ipRange = new Single();

        $this->assertInstanceOf('\\OpCacheGUI\\Network\\Ip\\Converter', $ipRange);
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Single::convert
     */
    public function testConvert()
    {
        $ipRange = new Single();

        $this->assertSame([2130706433.0, 2130706433.0], $ipRange->convert('127.0.0.1'));
    }
}
