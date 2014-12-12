<?php

namespace OpCacheGUITest\Unit\Network\Ip;

use OpCacheGUI\Network\Ip\Any;

class AnyTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testConstructCorrectInstance()
    {
        $ipRange = new Any();

        $this->assertInstanceOf('\\OpCacheGUI\\Network\\Ip\\Converter', $ipRange);
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Any::isValid
     */
    public function testIsValidValid()
    {
        $ipRange = new Any();

        $this->assertTrue($ipRange->isValid('*'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Any::isValid
     */
    public function testIsValidNotValidSingle()
    {
        $ipRange = new Any();

        $this->assertFalse($ipRange->isValid('127.0.0.1'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Any::isValid
     */
    public function testIsValidNotValidCidr()
    {
        $ipRange = new Any();

        $this->assertFalse($ipRange->isValid('127.0.0.1/32'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Any::isValid
     */
    public function testIsValidNotValidRange()
    {
        $ipRange = new Any();

        $this->assertFalse($ipRange->isValid('10.0.0.1-10.0.0.5'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Any::isValid
     */
    public function testIsValidNotValidLocalhost()
    {
        $ipRange = new Any();

        $this->assertFalse($ipRange->isValid('localhost'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Any::isValid
     */
    public function testIsValidNotValidWildcard()
    {
        $ipRange = new Any();

        $this->assertFalse($ipRange->isValid('10.0.0.*'));
    }

    /**
     * @covers OpCacheGUI\Network\Ip\Any::convert
     */
    public function testConvert()
    {
        $ipRange = new Any();

        $this->assertSame([0.0, 4294967295.0], $ipRange->convert('*'));
    }
}
