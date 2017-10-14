<?php

namespace OpCacheGUITest\Unit\Network\Ip;

use OpCacheGUI\Network\Ip\Converter;
use OpCacheGUI\Network\Ip\Range;
use PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
{
    /**
     */
    public function testConstructCorrectInstance()
    {
        $ipRange = new Range();

        $this->assertInstanceOf(Converter::class, $ipRange);
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Range::isValid
     */
    public function testIsValidValidWithoutSpaces()
    {
        $ipRange = new Range();

        $this->assertTrue($ipRange->isValid('10.0.0.1-10.0.0.5'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Range::isValid
     */
    public function testIsValidValidWithSpaces()
    {
        $ipRange = new Range();

        $this->assertTrue($ipRange->isValid('10.0.0.1 - 10.0.0.5'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Range::isValid
     */
    public function testIsValidNotValidCidr()
    {
        $ipRange = new Range();

        $this->assertFalse($ipRange->isValid('127.0.0.1/32'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Range::isValid
     */
    public function testIsValidNotValidLocalhost()
    {
        $ipRange = new Range();

        $this->assertFalse($ipRange->isValid('localhost'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Range::isValid
     */
    public function testIsValidNotValidSingle()
    {
        $ipRange = new Range();

        $this->assertFalse($ipRange->isValid('127.0.0.1'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Range::isValid
     */
    public function testIsValidNotValidWildcard()
    {
        $ipRange = new Range();

        $this->assertFalse($ipRange->isValid('10.0.0.*'));
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
