<?php

namespace OpCacheGUITest\Unit\Security\Generator;

use OpCacheGUI\Security\Generator\OpenSsl;

class OpenSslTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Security\Generator\OpenSsl::__construct
     */
    public function testConstructCorrectInterface()
    {
        $generator = new OpenSsl();

        $this->assertInstanceOf('\\OpCacheGUI\\Security\\Generator', $generator);
    }

    /**
     * @covers OpCacheGUI\Security\Generator\OpenSsl::__construct
     * @covers OpCacheGUI\Security\Generator\OpenSsl::generate
     */
    public function testGenerate()
    {
        $generator = new OpenSsl();

        $this->assertSame(128, strlen($generator->generate(128)));
    }

    /**
     * @covers OpCacheGUI\Security\Generator\OpenSsl::__construct
     * @covers OpCacheGUI\Security\Generator\OpenSsl::generate
     */
    public function testGenerateRandomTheStupidWay()
    {
        $generator = new OpenSsl();

        $strings = [];
        for ($i = 0; $i < 10; $i++) {
            $strings[] = $generator->generate(56);
        }

        $this->assertSame($strings, array_unique($strings));
    }
}
