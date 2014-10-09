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
        if (!$this->openSslEnabled()) {
            $this->markTestSkipped('The OpenSSL extension is not available.');
        }

        $generator = new OpenSsl();

        $this->assertInstanceOf('\\OpCacheGUI\\Security\\Generator', $generator);
    }

    /**
     * @covers OpCacheGUI\Security\Generator\OpenSsl::__construct
     */
    public function testConstructThrowsUpWhenOpenSslIsNotInstalled()
    {
        if ($this->openSslEnabled()) {
            $this->markTestSkipped('The OpenSSL extension is available.');
        }

        $this->setExpectedException('\\OpCacheGUI\\Security\\Generator\\UnsupportedAlgorithmException');

        new OpenSsl();
    }

    /**
     * @covers OpCacheGUI\Security\Generator\OpenSsl::__construct
     * @covers OpCacheGUI\Security\Generator\OpenSsl::generate
     */
    public function testGenerate()
    {
        if (!$this->openSslEnabled()) {
            $this->markTestSkipped('The OpenSSL extension is not available.');
        }

        $generator = new OpenSsl();

        $this->assertSame(128, strlen($generator->generate(128)));
    }

    /**
     * @covers OpCacheGUI\Security\Generator\OpenSsl::__construct
     * @covers OpCacheGUI\Security\Generator\OpenSsl::generate
     */
    public function testGenerateRandomTheStupidWay()
    {
        if (!$this->openSslEnabled()) {
            $this->markTestSkipped('The OpenSSL extension is not available.');
        }

        $generator = new OpenSsl();

        $strings = [];
        for ($i = 0; $i < 10; $i++) {
            $strings[] = $generator->generate(56);
        }

        $this->assertSame($strings, array_unique($strings));
    }

    /**
     * Simple method which checks whether these tests should be run
     *
     * @return boolean True when mcrypt is installed on the current system
     */
    private function openSslEnabled()
    {
        return function_exists('openssl_random_pseudo_bytes');
    }
}
