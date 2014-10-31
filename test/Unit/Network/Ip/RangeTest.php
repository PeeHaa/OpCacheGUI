<?php

namespace OpCacheGUITest\Unit\Network\Ip;

use OpCacheGUI\Network\Ip\Range;

class RangeTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testConstructCorrectInstance()
    {
        $ipRange = new Range();

        $this->assertInstanceOf('\\OpCacheGUI\\Network\\Ip\\Converter', $ipRange);
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Range::convert
     */
    public function testConvert()
    {
        $ipRange = new Range();

        $this->assertSame([167772161.0, 167772516.0], $ipRange->convert('10.0.0.1-10.0.1.100'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Range::convert
     */
    public function testConvertWithSpaces()
    {
        $ipRange = new Range();

        $this->assertSame([167772161.0, 167772516.0], $ipRange->convert('10.0.0.1 - 10.0.1.100'));
    }
}
