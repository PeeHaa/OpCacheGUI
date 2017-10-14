<?php

namespace OpCacheGUITest\Unit\Storage;

use OpCacheGUI\Storage\InvalidKeyException;
use OpCacheGUI\Storage\KeyValuePair;
use OpCacheGUI\Storage\Regeneratable;
use OpCacheGUI\Storage\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    /**
     */
    public function testCorrectInterfaceKeyValuePair()
    {
        $session = new Session();

        $this->assertInstanceOf(KeyValuePair::class, $session);
    }

    /**
     */
    public function testCorrectInterfaceRegeneratable()
    {
        $session = new Session();

        $this->assertInstanceOf(Regeneratable::class, $session);
    }

    /**
     * @covers OpCacheGUI\Storage\Session::set
     */
    public function testSet()
    {
        $session = new Session();

        $this->assertNull($session->set('key', 'value'));
    }

    /**
     * @covers OpCacheGUI\Storage\Session::set
     * @covers OpCacheGUI\Storage\Session::isKeyValid
     * @covers OpCacheGUI\Storage\Session::get
     */
    public function testGetValid()
    {
        $session = new Session();
        $session->set('key', 'value');

        $this->assertSame('value', $session->get('key'));
    }

    /**
     * @covers OpCacheGUI\Storage\Session::set
     * @covers OpCacheGUI\Storage\Session::isKeyValid
     * @covers OpCacheGUI\Storage\Session::get
     */
    public function testGetInvalid()
    {
        $session = new Session();
        $this->expectException(InvalidKeyException::class);

        $session->get('key');
    }

    /**
     * @covers OpCacheGUI\Storage\Session::isKeyValid
     */
    public function testIsKeyValidFail()
    {
        $session = new Session();

        $this->assertFalse(false, $session->isKeyValid('unknownkey'));
    }

    /**
     * @covers OpCacheGUI\Storage\Session::set
     * @covers OpCacheGUI\Storage\Session::isKeyValid
     */
    public function testIsKeyValidSuccess()
    {
        $session = new Session();
        $session->set('key', 'value');

        $this->assertTrue($session->isKeyValid('key'));
    }
}
