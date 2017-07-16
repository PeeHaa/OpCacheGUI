<?php

namespace OpCacheGUITest\Unit\Security\Generator;

use PHPUnit\Framework\TestCase;

use OpCacheGUI\Security\Generator;
use OpCacheGUI\Security\Generator\Urandom;
use OpCacheGUI\Security\Generator\UnsupportedAlgorithmException;

class UrandomTest extends TestCase
{
    /**
     * @covers OpCacheGUI\Security\Generator\Urandom::__construct
     */
    public function testConstructCorrectInterface()
    {
        if ($this->onWindows()) {
            $this->markTestSkipped('The current operating system does not support /dev/urandom');
        }

        $generator = new Urandom();

        $this->assertInstanceOf(Generator::class, $generator);
    }

    /**
     * @covers OpCacheGUI\Security\Generator\Urandom::__construct
     */
    public function testConstructThrowsUpWhenOnWindows()
    {
        if (!$this->onWindows()) {
            $this->markTestSkipped('The current operating system does support /dev/urandom');
        }

        $this->expectException(UnsupportedAlgorithmException::class);

        new Urandom();
    }

    /**
     * @covers OpCacheGUI\Security\Generator\Urandom::__construct
     * @covers OpCacheGUI\Security\Generator\Urandom::generate
     */
    public function testGenerate()
    {
        if ($this->onWindows()) {
            $this->markTestSkipped('The current operating system does not support /dev/urandom');
        }

        $generator = new Urandom();

        $this->assertSame(128, strlen($generator->generate(128)));
    }

    /**
     * @covers OpCacheGUI\Security\Generator\Urandom::__construct
     * @covers OpCacheGUI\Security\Generator\Urandom::generate
     */
    public function testGenerateRandomTheStupidWay()
    {
        if ($this->onWindows()) {
            $this->markTestSkipped('The current operating system does not support /dev/urandom');
        }

        $generator = new Urandom();

        $strings = [];
        for ($i = 0; $i < 10; $i++) {
            $strings[] = $generator->generate(56);
        }

        $this->assertSame($strings, array_unique($strings));
    }

    /**
     * Simple method which checks whether these tests should be run
     *
     * @return boolean True when on windows
     */
    private function onWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }
}
