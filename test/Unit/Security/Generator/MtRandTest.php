<?php

namespace OpCacheGUITest\Unit\Security\Generator;

use OpCacheGUI\Security\Generator\MtRand;

class MtRandTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testConstructCorrectInterface()
    {
        $generator = new MtRand();

        $this->assertInstanceOf('\\OpCacheGUI\\Security\\Generator', $generator);
    }

    /**
     * @covers OpCacheGUI\Security\Generator\MtRand::generate
     */
    public function testGenerate()
    {
        $generator = new MtRand();

        $this->assertSame(128, strlen($generator->generate(128)));
    }

    /**
     * @covers OpCacheGUI\Security\Generator\MtRand::generate
     */
    public function testGenerateRandomTheStupidWay()
    {
        $generator = new MtRand();

        $strings = [];
        for ($i = 0; $i < 10; $i++) {
            $strings[] = $generator->generate(56);
        }

        $this->assertSame($strings, array_unique($strings));
    }
}
