<?php

namespace OpCacheGUITest\Unit\Network;

use OpCacheGUI\Network\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Network\Request::__construct
     */
    public function testConstructCorrectInstance()
    {
        $request = new Request([], [], ['REQUEST_URI' => '']);

        $this->assertInstanceOf('\\OpCacheGUI\\Network\\RequestData', $request);
    }

    /**
     * @covers OpCacheGUI\Network\Request::__construct
     * @covers OpCacheGUI\Network\Request::get
     */
    public function testGetNoQueryString()
    {
        $request = new Request([], [], ['REQUEST_URI' => '']);

        $this->assertSame('', $request->get());
    }

    /**
     * @covers OpCacheGUI\Network\Request::__construct
     * @covers OpCacheGUI\Network\Request::get
     */
    public function testGetQueryString()
    {
        $request = new Request(['foo' => '', 'bar' => ''], [], ['REQUEST_URI' => '']);

        $this->assertSame('foo', $request->get());
    }

    /**
     * @covers OpCacheGUI\Network\Request::__construct
     * @covers OpCacheGUI\Network\Request::path
     */
    public function testPathEmptyRequestUri()
    {
        $request = new Request([], [], ['REQUEST_URI' => '']);

        $this->assertSame('', $request->path());
    }

    /**
     * @covers OpCacheGUI\Network\Request::__construct
     * @covers OpCacheGUI\Network\Request::path
     */
    public function testPathOnlySlash()
    {
        $request = new Request([], [], ['REQUEST_URI' => '/']);

        $this->assertSame('', $request->path());
    }

    /**
     * @covers OpCacheGUI\Network\Request::__construct
     * @covers OpCacheGUI\Network\Request::path
     */
    public function testPathSingle()
    {
        $request = new Request([], [], ['REQUEST_URI' => '/foo']);

        $this->assertSame('foo', $request->path());
    }

    /**
     * @covers OpCacheGUI\Network\Request::__construct
     * @covers OpCacheGUI\Network\Request::path
     */
    public function testPathMultiple()
    {
        $request = new Request([], [], ['REQUEST_URI' => '/foo/bar']);

        $this->assertSame('bar', $request->path());
    }

    /**
     * @covers OpCacheGUI\Network\Request::__construct
     * @covers OpCacheGUI\Network\Request::path
     */
    public function testPathTrailingSlash()
    {
        $request = new Request([], [], ['REQUEST_URI' => '/foo/bar/']);

        $this->assertSame('bar', $request->path());
    }

    /**
     * @covers OpCacheGUI\Network\Request::__construct
     * @covers OpCacheGUI\Network\Request::getVerb
     */
    public function testGetVerb()
    {
        $request = new Request([], [], ['REQUEST_URI' => '', 'REQUEST_METHOD' => 'POST']);

        $this->assertSame('POST', $request->getVerb());
    }

    /**
     * @covers OpCacheGUI\Network\Request::__construct
     * @covers OpCacheGUI\Network\Request::post
     */
    public function testPost()
    {
        $request = new Request([], ['foo' => 'bar'], ['REQUEST_URI' => '']);

        $this->assertSame('bar', $request->post('foo'));
    }
}
