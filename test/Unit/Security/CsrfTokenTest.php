<?php

namespace OpCacheGUI\Unit\Security;

use OpCacheGUI\Security\CsrfToken;
use OpCacheGUI\Security\Generator;
use OpCacheGUI\Storage\KeyValuePair;
use PHPUnit\Framework\TestCase;

class CsrfTokenTest extends TestCase
{
    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::get
     */
    public function testGetWhenAlreadyStored()
    {
        /** @var KeyValuePair|\PHPUnit_Framework_MockObject_MockObject $storage */
        $storage = $this->createMock(KeyValuePair::class);
        $storage->method('isKeyValid')->willReturn(true);
        $storage->method('get')->will($this->returnArgument(0));

        $token = new CsrfToken($storage);

        $this->assertSame('csrfToken', $token->get());
    }

    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::get
     * @covers OpCacheGUI\Security\CsrfToken::generate
     */
    public function testGetWhenNotStored()
    {
        /** @var KeyValuePair|\PHPUnit_Framework_MockObject_MockObject $storage */
        $storage = $this->createMock(KeyValuePair::class);
        $storage->method('isKeyValid')->willReturn(false);
        $storage->method('get')->will($this->returnArgument(0));

        $generator = $this->createMock(Generator::class);
        $generator->method('generate')->willReturn('12345678901234567890123456789012345678901234567890123456');

        $token = new CsrfToken($storage);

        $this->assertSame('csrfToken', $token->get());
    }

    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::validate
     * @covers OpCacheGUI\Security\CsrfToken::get
     */
    public function testValidateValid()
    {
        /** @var KeyValuePair|\PHPUnit_Framework_MockObject_MockObject $storage */
        $storage = $this->createMock(KeyValuePair::class);
        $storage->method('isKeyValid')->willReturn(true);
        $storage->method('get')->will($this->returnArgument(0));

        $token = new CsrfToken($storage);

        $this->assertTrue($token->validate('csrfToken'));
    }

    /**
     * @covers OpCacheGUI\Security\CsrfToken::__construct
     * @covers OpCacheGUI\Security\CsrfToken::validate
     * @covers OpCacheGUI\Security\CsrfToken::get
     */
    public function testValidateNotValid()
    {
        /** @var KeyValuePair|\PHPUnit_Framework_MockObject_MockObject $storage */
        $storage = $this->createMock(KeyValuePair::class);
        $storage->method('isKeyValid')->willReturn(true);
        $storage->method('get')->will($this->returnArgument(0));

        $token = new CsrfToken($storage);

        $this->assertFalse($token->validate('notvalid'));
    }
}
