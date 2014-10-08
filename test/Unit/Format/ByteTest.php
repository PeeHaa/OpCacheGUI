<?php

namespace OpCacheGUITest\Unit\Format;

use OpCacheGUI\Format\Byte;

class ByteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Format\Byte::format
     */
    public function testFormatWithBytes()
    {
        $formatter = new Byte();

        $this->assertSame('120B', $formatter->format(120));
    }

    /**
     * @covers OpCacheGUI\Format\Byte::format
     */
    public function testFormatWithKiloBytes()
    {
        $formatter = new Byte();

        $this->assertSame('11.72KB', $formatter->format(12000));
    }

    /**
     * @covers OpCacheGUI\Format\Byte::format
     */
    public function testFormatWithMegaBytes()
    {
        $formatter = new Byte();

        $this->assertSame('11.44MB', $formatter->format(12000000));
    }

    /**
     * @covers OpCacheGUI\Format\Byte::format
     */
    public function testFormatWithGigaBytes()
    {
        $formatter = new Byte();

        $this->assertSame('11.18GB', $formatter->format(12000000000));
    }

    /**
     * @covers OpCacheGUI\Format\Byte::format
     */
    public function testFormatWithMoteThanGigaBytes()
    {
        $formatter = new Byte();

        $this->assertSame('10913.94GB', $formatter->format(12000000000000000));
    }

    /**
     * @covers OpCacheGUI\Format\Byte::format
     */
    public function testFormatWithKiloBytesAndNoDecimals()
    {
        $formatter = new Byte();

        $this->assertSame('12KB', $formatter->format(12000, 0));
    }

    /**
     * @covers OpCacheGUI\Format\Byte::format
     */
    public function testFormatWithKiloBytesAndOneDecimals()
    {
        $formatter = new Byte();

        $this->assertSame('11.7KB', $formatter->format(12000, 1));
    }

    /**
     * @covers OpCacheGUI\Format\Byte::format
     */
    public function testFormatWithKiloBytesAndFourDecimals()
    {
        $formatter = new Byte();

        $this->assertSame('11.7188KB', $formatter->format(12000, 4));
    }
}
