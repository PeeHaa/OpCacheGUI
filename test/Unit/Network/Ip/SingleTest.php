<?php

namespace OpCacheGUITest\Unit\Network\Ip;

use OpCacheGUI\Network\Ip\Single;

class SingleTest extends \PHPUnit_Framework_TestCase// implements Converter
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

        $this->assertSame(['127.0.0.1', '127.0.0.1'], $ipRange->convert('127.0.0.1'));
    }
}
