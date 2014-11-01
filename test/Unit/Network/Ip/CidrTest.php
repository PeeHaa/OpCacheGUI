<?php

namespace OpCacheGUITest\Unit\Network\Ip;

use OpCacheGUI\Network\Ip\Cidr;

class CidrTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testConstructCorrectInstance()
    {
        $ipRange = new Cidr();

        $this->assertInstanceOf('\\OpCacheGUI\\Network\\Ip\\Converter', $ipRange);
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Cidr::convert
     */
    public function testConvert()
    {
        $ipRange = new Cidr();

        $this->assertSame([167772160.0, 167772327.0], $ipRange->convert('10.0.0.40/25'));
    }
}
