<?php

namespace OpCacheGUITest\Unit\Auth;

use OpCacheGUI\Auth\Ip;

class IpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Auth\Ip::__construct
     */
    public function testConstructCorrectInstance()
    {
        $whitelist = new Ip([]);

        $this->assertInstanceOf('\\OpCacheGUI\\Auth\\Whitelist', $whitelist);
    }

    /**
     * @covers OpCacheGUI\Auth\Ip::__construct
     * @covers OpCacheGUI\Auth\Ip::buildWhitelist
     */
    public function testBuildListWithoutAddresses()
    {
        $whitelist = new Ip([]);

        $this->assertNull($whitelist->buildWhitelist([]));
    }

    /**
     * @covers OpCacheGUI\Auth\Ip::__construct
     * @covers OpCacheGUI\Auth\Ip::buildWhitelist
     * @covers OpCacheGUI\Auth\Ip::addWhitelist
     */
    public function testBuildListWithoutConverters()
    {
        $whitelist = new Ip([]);

        $this->assertNull($whitelist->buildWhitelist(['localhost']));
    }

    /**
     * @covers OpCacheGUI\Auth\Ip::__construct
     * @covers OpCacheGUI\Auth\Ip::buildWhitelist
     * @covers OpCacheGUI\Auth\Ip::addWhitelist
     */
    public function testBuildListWithValidConverter()
    {
        $converter = $this->getMock('\\OpCacheGUI\\Network\\Ip\\Converter');
        $converter->method('isValid')->will($this->returnValue(true));

        $whitelist = new Ip([$converter]);

        $this->assertNull($whitelist->buildWhitelist(['localhost']));
    }

    /**
     * @covers OpCacheGUI\Auth\Ip::__construct
     * @covers OpCacheGUI\Auth\Ip::buildWhitelist
     * @covers OpCacheGUI\Auth\Ip::addWhitelist
     */
    public function testBuildListWithInvalidConverter()
    {
        $converter = $this->getMock('\\OpCacheGUI\\Network\\Ip\\Converter');
        $converter->method('isValid')->will($this->returnValue(false));

        $whitelist = new Ip([$converter]);

        $this->assertNull($whitelist->buildWhitelist(['localhost']));
    }

    /**
     * @covers OpCacheGUI\Auth\Ip::__construct
     * @covers OpCacheGUI\Auth\Ip::buildWhitelist
     * @covers OpCacheGUI\Auth\Ip::addWhitelist
     * @covers OpCacheGUI\Auth\Ip::isAllowed
     */
    public function testIsAllowedTrue()
    {
        $converter = $this->getMock('\\OpCacheGUI\\Network\\Ip\\Converter');
        $converter->method('isValid')->will($this->returnValue(true));
        $converter->method('convert')->will($this->returnValue([167772161, 167772165]));

        $whitelist = new Ip([$converter]);

        $whitelist->buildWhitelist(['10.0.0.1-10.0.0.5']);

        $this->assertTrue($whitelist->isAllowed('10.0.0.2'));
    }

    /**
     * @covers OpCacheGUI\Auth\Ip::__construct
     * @covers OpCacheGUI\Auth\Ip::buildWhitelist
     * @covers OpCacheGUI\Auth\Ip::addWhitelist
     * @covers OpCacheGUI\Auth\Ip::isAllowed
     */
    public function testIsAllowedFalse()
    {
        $converter = $this->getMock('\\OpCacheGUI\\Network\\Ip\\Converter');
        $converter->method('isValid')->will($this->returnValue(true));
        $converter->method('convert')->will($this->returnValue([167772161, 167772161]));

        $whitelist = new Ip([$converter]);

        $whitelist->buildWhitelist(['10.0.0.1-10.0.0.5']);

        $this->assertFalse($whitelist->isAllowed('10.0.0.2'));
    }
}
