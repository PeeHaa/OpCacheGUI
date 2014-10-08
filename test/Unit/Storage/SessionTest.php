<?php

namespace OpCacheGUITest\Unit\Storage;

use OpCacheGUI\Storage\Session;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    /**
     */
    public function testCorrectInterfaceKeyValuePair()
    {
        $session = new Session();

        $this->assertInstanceOf('\\OpCacheGUI\\Storage\\KeyValuePair', $session);
    }

    /**
     */
    public function testCorrectInterfaceRegeneratable()
    {
        $session = new Session();

        $this->assertInstanceOf('\\OpCacheGUI\\Storage\\Regeneratable', $session);
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
        $this->setExpectedException('\\OpCacheGUI\\Storage\\InvalidKeyException');

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
