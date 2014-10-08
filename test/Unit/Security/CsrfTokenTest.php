<?php

namespace OpCacheGUI\Security;

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
        $storage = $this->getMock('\\OpCacheGUI\\Storage\\KeyValuePair');
        $storage->method('isKeyValid')->willReturn(true);
        $storage->method('get')->will($this->returnArgument(0));

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
        $storage = $this->getMock('\\OpCacheGUI\\Storage\\KeyValuePair');
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
        $storage = $this->getMock('\\OpCacheGUI\\Storage\\KeyValuePair');
        $storage->method('isKeyValid')->willReturn(true);
        $storage->method('get')->will($this->returnArgument(0));

        $token = new CsrfToken($storage);

        $this->assertFalse($token->validate('notvalid'));
    }
}
