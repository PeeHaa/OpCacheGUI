<?php

namespace OpCacheGUITest\Unit\Security\Generator;

use OpCacheGUI\Security\Generator\Mcrypt;

class McryptTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Security\Generator\Mcrypt::__construct
     */
    public function testConstructCorrectInterface()
    {
        $generator = new Mcrypt();

        $this->assertInstanceOf('\\OpCacheGUI\\Security\\Generator', $generator);
    }

    /**
     * @covers OpCacheGUI\Security\Generator\Mcrypt::__construct
     * @covers OpCacheGUI\Security\Generator\Mcrypt::generate
     */
    public function testGenerate()
    {
        $generator = new Mcrypt();

        $this->assertSame(128, strlen($generator->generate(128)));
    }

    /**
     * @covers OpCacheGUI\Security\Generator\Mcrypt::__construct
     * @covers OpCacheGUI\Security\Generator\Mcrypt::generate
     */
    public function testGenerateRandomTheStupidWay()
    {
        $generator = new Mcrypt();

        $strings = [];
        for ($i = 0; $i < 10; $i++) {
            $strings[] = $generator->generate(56);
        }

        $this->assertSame($strings, array_unique($strings));
    }
}
