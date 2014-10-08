<?php

namespace OpCacheGUITest\Unit\Security\Generator;

use OpCacheGUI\Security\Generator\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Security\Generator\Factory::build
     */
    public function testBuildCorrectInterface()
    {
        $factory = new Factory();

        $this->assertInstanceOf('\\OpCacheGUI\\Security\\Generator\\Builder', $factory);
    }

    /**
     * @covers OpCacheGUI\Security\Generator\Factory::build
     */
    public function testBuildFakeGeneratorSuccess()
    {
        $factory = new Factory();

        $this->assertInstanceOf(
            '\\OpCacheGUI\\Security\\Generator', $factory->build('\\OpCacheGUITest\\Mocks\\Security\\Generator\\Fake')
        );
    }

    /**
     * @covers OpCacheGUI\Security\Generator\Factory::build
     */
    public function testBuildUnknownGeneratorFail()
    {
        $factory = new Factory();

        $this->setExpectedException('\\OpCacheGUI\\Security\\Generator\\InvalidGeneratorException');

        $factory->build('\\OpCacheGUIUnknown\\UnknownGenerator');
    }

    /**
     * @covers OpCacheGUI\Security\Generator\Factory::build
     */
    public function testBuildThrowsUpOnNotImplementingGenerator()
    {
        $factory = new Factory();

        $this->setExpectedException('\\OpCacheGUI\\Security\\Generator\\InvalidGeneratorException');

        $factory->build('\\OpCacheGUITest\\Mocks\\Security\\Generator\\Invalid');
    }
}
