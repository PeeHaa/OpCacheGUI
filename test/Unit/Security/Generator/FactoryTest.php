<?php

namespace OpCacheGUITest\Unit\Security\Generator;

use PHPUnit\Framework\TestCase;

use OpCacheGUI\Security\Generator;
use OpCacheGUI\Security\Generator\Factory;
use OpCacheGUI\Security\Generator\InvalidGeneratorException;
use OpCacheGUI\Security\Generator\Builder;

class FactoryTest extends TestCase
{
    /**
     * @covers OpCacheGUI\Security\Generator\Factory::build
     */
    public function testBuildCorrectInterface()
    {
        $factory = new Factory();

        $this->assertInstanceOf(Builder::class, $factory);
    }

    /**
     * @covers OpCacheGUI\Security\Generator\Factory::build
     */
    public function testBuildFakeGeneratorSuccess()
    {
        $factory = new Factory();

        $this->assertInstanceOf(
            Generator::class, $factory->build('\\OpCacheGUITest\\Mocks\\Security\\Generator\\Fake')
        );
    }

    /**
     * @covers OpCacheGUI\Security\Generator\Factory::build
     */
    public function testBuildUnknownGeneratorFail()
    {
        $factory = new Factory();

        $this->expectException(InvalidGeneratorException::class);

        $factory->build('\\OpCacheGUIUnknown\\UnknownGenerator');
    }

    /**
     * @covers OpCacheGUI\Security\Generator\Factory::build
     */
    public function testBuildThrowsUpOnNotImplementingGenerator()
    {
        $factory = new Factory();

        $this->expectException(InvalidGeneratorException::class);

        $factory->build('\\OpCacheGUITest\\Mocks\\Security\\Generator\\Invalid');
    }
}
