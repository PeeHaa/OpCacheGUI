<?php

namespace OpCacheGUITest\Unit\Network\Ip;

use OpCacheGUI\Network\Ip\Wildcard;

class WildcardTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testConstructCorrectInstance()
    {
        $ipRange = new Wildcard();

        $this->assertInstanceOf('\\OpCacheGUI\\Network\\Ip\\Converter', $ipRange);
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Wildcard::convert
     */
    public function testConvertOneWildcard()
    {
        $ipRange = new Wildcard();

        $this->assertSame([2130706432.0, 2130706687.0], $ipRange->convert('127.0.0.*'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Wildcard::convert
     */
    public function testConvertTwoWildcards()
    {
        $ipRange = new Wildcard();

        $this->assertSame([2130706432.0, 2130771967.0], $ipRange->convert('127.0.*.*'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Wildcard::convert
     */
    public function testConvertThreeWildcards()
    {
        $ipRange = new Wildcard();

        $this->assertSame([2130706432.0, 2147483647.0], $ipRange->convert('127.*.*.*'));
    }
}
