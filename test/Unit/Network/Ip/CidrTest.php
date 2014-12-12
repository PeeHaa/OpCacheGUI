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
     * @covers OpCacheGUI\Network\Ip\Cidr::isValid
     */
    public function testIsValidValid()
    {
        $ipRange = new Cidr();

        $this->assertTrue($ipRange->isValid('10.0.0.1/25'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Cidr::isValid
     */
    public function testIsValidNotValidSingle()
    {
        $ipRange = new Cidr();

        $this->assertFalse($ipRange->isValid('127.0.0.1'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Cidr::isValid
     */
    public function testIsValidNotValidRange()
    {
        $ipRange = new Cidr();

        $this->assertFalse($ipRange->isValid('10.0.0.1-10.0.0.5'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Cidr::isValid
     */
    public function testIsValidNotValidLocalhost()
    {
        $ipRange = new Cidr();

        $this->assertFalse($ipRange->isValid('localhost'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Cidr::isValid
     */
    public function testIsValidNotValidWildcard()
    {
        $ipRange = new Cidr();

        $this->assertFalse($ipRange->isValid('10.0.0.*'));
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
