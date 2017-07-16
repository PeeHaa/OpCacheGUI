<?php

namespace OpCacheGUI\Unit\Security;

use PHPUnit\Framework\TestCase;

use OpCacheGUI\Security\CsrfToken;
use OpCacheGUI\Security\Generator\InvalidLengthException;
use OpCacheGUI\Storage\KeyValuePair;
use OpCacheGUI\Security\Generator\Builder;
use OpCacheGUI\Security\Generator;

class CsrfTokenTest extends TestCase
{
    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::get
     */
    public function testGetWhenAlreadyStored()
    {
        $storage = $this->getMockBuilder(KeyValuePair::class)->getMock();
        $storage->method('isKeyValid')->willReturn(true);
        $storage->method('get')->will($this->returnArgument(0));

        $token = new CsrfToken($storage, $this->getMockBuilder(Builder::class)->getMock());

        $this->assertSame('csrfToken', $token->get());
    }

    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::get
     * @covers OpCacheGUI\Security\CsrfToken::generate
     */
    public function testGetWhenNotStored()
    {
        $storage = $this->getMockBuilder(KeyValuePair::class)->getMock();
        $storage->method('isKeyValid')->willReturn(false);
        $storage->method('get')->will($this->returnArgument(0));

        $generator = $this->getMockBuilder(Generator::class)->getMock();
        $generator->method('generate')->willReturn('12345678901234567890123456789012345678901234567890123456');

        $factory = $this->getMockBuilder(Builder::class)->getMock();
        $factory->method('build')->willReturn($generator);

        $token = new CsrfToken($storage, $factory);

        $this->assertSame('csrfToken', $token->get());
    }

    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::get
     * @covers OpCacheGUI\Security\CsrfToken::generate
     */
    public function testGetWhenNotStoredUnsupportedAlgoFirst()
    {
        $storage = $this->getMockBuilder(KeyValuePair::class)->getMock();
        $storage->method('isKeyValid')->willReturn(false);
        $storage->method('get')->will($this->returnArgument(0));

        $generator = $this->getMockBuilder(Generator::class)->getMock();
        $generator->method('generate')->willReturn('12345678901234567890123456789012345678901234567890123456');

        $factory = $this->getMockBuilder(Builder::class)->getMock();
        $factory->method('build')->will($this->onConsecutiveCalls(
            $this->returnCallback(function () {
                return new \OpCacheGUITest\Mocks\Security\Generator\Unsupported();
            }),
            $generator
        ));

        $token = new CsrfToken($storage, $factory);

        $this->assertSame('csrfToken', $token->get());
    }

    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::get
     * @covers OpCacheGUI\Security\CsrfToken::generate
     */
    public function testGetThrowsUpOnInvalidLength()
    {
        $storage = $this->getMockBuilder(KeyValuePair::class)->getMock();
        $storage->method('isKeyValid')->willReturn(false);
        $storage->method('get')->will($this->returnArgument(0));

        $generator = $this->getMockBuilder(Generator::class)->getMock();
        $generator->method('generate')->willReturn('1234567890');

        $factory = $this->getMockBuilder(Builder::class)->getMock();
        $factory->method('build')->willReturn($generator);

        $token = new CsrfToken($storage, $factory);

        $this->expectException(InvalidLengthException::class);

        $token->get();
    }

    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::validate
     * @covers OpCacheGUI\Security\CsrfToken::get
     */
    public function testValidateValid()
    {
        $storage = $this->getMockBuilder(KeyValuePair::class)->getMock();
        $storage->method('isKeyValid')->willReturn(true);
        $storage->method('get')->will($this->returnArgument(0));

        $token = new CsrfToken($storage, $this->getMockBuilder(Builder::class)->getMock());

        $this->assertTrue($token->validate('csrfToken'));
    }

    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::validate
     * @covers OpCacheGUI\Security\CsrfToken::get
     */
    public function testValidateNotValid()
    {
        $storage = $this->getMockBuilder(KeyValuePair::class)->getMock();
        $storage->method('isKeyValid')->willReturn(true);
        $storage->method('get')->will($this->returnArgument(0));

        $token = new CsrfToken($storage, $this->getMockBuilder(Builder::class)->getMock());

        $this->assertFalse($token->validate('notvalid'));
    }

    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::addAlgo
     * @covers OpCacheGUI\Security\CsrfToken::get
     * @covers OpCacheGUI\Security\CsrfToken::generate
     */
    public function testGetWhenNotStoredAddedCustomAlgo()
    {
        $storage = $this->getMockBuilder(KeyValuePair::class)->getMock();
        $storage->method('isKeyValid')->willReturn(false);
        $storage->method('get')->will($this->returnArgument(0));
        $storage->method('set')->will($this->returnCallback(function ($key, $value) {
            $this->assertSame('csrfToken', $key);
            $this->assertSame('12345678901234567890123456789012345678901234567890123456', $value);
        }));

        $generator = $this->getMockBuilder(Generator::class)->getMock();
        $generator->method('generate')->willReturn('12345678901234567890123456789012345678901234567890123456');

        $factory = $this->getMockBuilder(Builder::class)->getMock();
        $factory->method('build')->willReturn($generator);

        $token = new CsrfToken($storage, $factory);

        $token->addAlgo('\\Foo');
    }
}
