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
     * @covers OpCacheGUI\Network\Ip\Localhost::isValid
     */
    public function testIsValidValid()
    {
        $ipRange = new Localhost();

        $this->assertTrue($ipRange->isValid('localhost'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Localhost::isValid
     */
    public function testIsValidNotValidCidr()
    {
        $ipRange = new Localhost();

        $this->assertFalse($ipRange->isValid('127.0.0.1/32'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Localhost::isValid
     */
    public function testIsValidNotValidRange()
    {
        $ipRange = new Localhost();

        $this->assertFalse($ipRange->isValid('10.0.0.1-10.0.0.5'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Localhost::isValid
     */
    public function testIsValidNotValidSingle()
    {
        $ipRange = new Localhost();

        $this->assertFalse($ipRange->isValid('127.0.0.1'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Localhost::isValid
     */
    public function testIsValidNotValidWildcard()
    {
        $ipRange = new Localhost();

        $this->assertFalse($ipRange->isValid('10.0.0.*'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Localhost::convert
     */
    public function testConvert()
    {
        $ipRange = new Localhost();

        $this->assertSame([2130706433.0, 2130706433.0], $ipRange->convert('localhost'));
    }
}
