<?php

namespace OpCacheGUI\Unit\Security;

use OpCacheGUI\Security\CsrfToken;

class CsrfTokenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::get
     */
    public function testGetWhenAlreadyStored()
    {
        $storage = $this->getMock('\\OpCacheGUI\\Storage\\KeyValuePair');
        $storage->method('isKeyValid')->willReturn(true);
        $storage->method('get')->will($this->returnArgument(0));

        $token = new CsrfToken($storage, $this->getMock('\\OpCacheGUI\\Security\\Generator\\Builder'));

        $this->assertSame('csrfToken', $token->get());
    }

    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::get
     * @covers OpCacheGUI\Security\CsrfToken::generate
     */
    public function testGetWhenNotStored()
    {
        $storage = $this->getMock('\\OpCacheGUI\\Storage\\KeyValuePair');
        $storage->method('isKeyValid')->willReturn(false);
        $storage->method('get')->will($this->returnArgument(0));

        $generator = $this->getMock('\\OpCacheGUI\\Security\\Generator');
        $generator->method('generate')->willReturn('12345678901234567890123456789012345678901234567890123456');

        $factory = $this->getMock('\\OpCacheGUI\\Security\\Generator\\Builder');
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
        $storage = $this->getMock('\\OpCacheGUI\\Storage\\KeyValuePair');
        $storage->method('isKeyValid')->willReturn(false);
        $storage->method('get')->will($this->returnArgument(0));

        $generator = $this->getMock('\\OpCacheGUI\\Security\\Generator');
        $generator->method('generate')->willReturn('12345678901234567890123456789012345678901234567890123456');

        $factory = $this->getMock('\\OpCacheGUI\\Security\\Generator\\Builder');
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
        $storage = $this->getMock('\\OpCacheGUI\\Storage\\KeyValuePair');
        $storage->method('isKeyValid')->willReturn(false);
        $storage->method('get')->will($this->returnArgument(0));

        $generator = $this->getMock('\\OpCacheGUI\\Security\\Generator');
        $generator->method('generate')->willReturn('1234567890');

        $factory = $this->getMock('\\OpCacheGUI\\Security\\Generator\\Builder');
        $factory->method('build')->willReturn($generator);

        $token = new CsrfToken($storage, $factory);

        $this->setExpectedException('\\OpCacheGUI\\Security\\Generator\\InvalidLengthException');

        $token->get();
    }

    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::validate
     * @covers OpCacheGUI\Security\CsrfToken::get
     */
    public function testValidateValid()
    {
        $storage = $this->getMock('\\OpCacheGUI\\Storage\\KeyValuePair');
        $storage->method('isKeyValid')->willReturn(true);
        $storage->method('get')->will($this->returnArgument(0));

        $token = new CsrfToken($storage, $this->getMock('\\OpCacheGUI\\Security\\Generator\\Builder'));

        $this->assertTrue($token->validate('csrfToken'));
    }

    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::validate
     * @covers OpCacheGUI\Security\CsrfToken::get
     */
    public function testValidateNotValid()
    {
        $storage = $this->getMock('\\OpCacheGUI\\Storage\\KeyValuePair');
        $storage->method('isKeyValid')->willReturn(true);
        $storage->method('get')->will($this->returnArgument(0));

        $token = new CsrfToken($storage, $this->getMock('\\OpCacheGUI\\Security\\Generator\\Builder'));

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
        $storage = $this->getMock('\\OpCacheGUI\\Storage\\KeyValuePair');
        $storage->method('isKeyValid')->willReturn(false);
        $storage->method('get')->will($this->returnArgument(0));
        $storage->method('set')->will($this->returnCallback(function ($key, $value) {
            $this->assertSame('csrfToken', $key);
            $this->assertSame('12345678901234567890123456789012345678901234567890123456', $value);
        }));

        $generator = $this->getMock('\\OpCacheGUI\\Security\\Generator');
        $generator->method('generate')->willReturn('12345678901234567890123456789012345678901234567890123456');

        $factory = $this->getMock('\\OpCacheGUI\\Security\\Generator\\Builder');
        $factory->method('build')->willReturn($generator);

        $token = new CsrfToken($storage, $factory);

        $token->addAlgo('\\Foo');
    }
}
