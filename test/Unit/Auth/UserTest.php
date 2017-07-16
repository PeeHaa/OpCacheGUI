<?php

namespace OpCacheGUITest\Unit\Auth;

use PHPUnit\Framework\TestCase;

use OpCacheGUI\Auth\User;
use OpCacheGUI\Auth\Whitelist;
use OpCacheGUI\Storage\Session;

class UserTest extends TestCase
{
    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::isLoggedIn
     */
    public function testIsloggedInTrue()
    {
        $session = $this->getMockBuilder(Session::class)->getMock();
        $session->method('isKeyValid')->willReturn(true);

        $whitelist = $this->getMockBuilder(Whitelist::class)->getMock();

        $user = new User($session, 'user', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertTrue($user->isLoggedIn());
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::isLoggedIn
     */
    public function testIsloggedInFalse()
    {
        $session = $this->getMockBuilder(Session::class)->getMock();
        $session->method('isKeyValid')->willReturn(false);

        $whitelist = $this->getMockBuilder(Whitelist::class)->getMock();

        $user = new User($session, 'user', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertFalse($user->isLoggedIn());
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::requiresLogin
     */
    public function testRequiresLoginLoginNotEnabledInConfig()
    {
        $whitelist = $this->getMockBuilder(Whitelist::class)->getMock();

        $user = new User($this->getMockBuilder(Session::class)->getMock(), '', '', $whitelist);

        $this->assertFalse($user->requiresLogin());
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::isLoggedIn
     * @covers OpCacheGUI\Auth\User::requiresLogin
     */
    public function testRequiresLoginRequiredButNotLoggedIn()
    {
        $session = $this->getMockBuilder(Session::class)->getMock();
        $session->method('isKeyValid')->willReturn(false);

        $whitelist = $this->getMockBuilder(Whitelist::class)->getMock();

        $user = new User($session, 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertTrue($user->requiresLogin());
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::isLoggedIn
     * @covers OpCacheGUI\Auth\User::requiresLogin
     */
    public function testRequiresLoginRequiredAndLoggedIn()
    {
        $session = $this->getMockBuilder(Session::class)->getMock();
        $session->method('isKeyValid')->willReturn(true);

        $whitelist = $this->getMockBuilder(Whitelist::class)->getMock();

        $user = new User($session, 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertFalse($user->requiresLogin());
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginFailedIncorrectPassword()
    {
        $whitelist = $this->getMockBuilder(Whitelist::class)->getMock();
        $whitelist->method('isAllowed')->will($this->returnValue(true));

        $user = new User($this->getMockBuilder(Session::class)->getMock(), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertFalse($user->login('foo', 'nothashedbar', '127.0.0.1'));
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginFailedIncorrectUsername()
    {
        $whitelist = $this->getMockBuilder(Whitelist::class)->getMock();
        $whitelist->method('isAllowed')->will($this->returnValue(true));

        $user = new User($this->getMockBuilder(Session::class)->getMock(), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertFalse($user->login('incorrect', 'bar', '127.0.0.1'));
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginFailedIncorrectPasswordAndUsername()
    {
        $whitelist = $this->getMockBuilder(Whitelist::class)->getMock();
        $whitelist->method('isAllowed')->will($this->returnValue(true));

        $user = new User($this->getMockBuilder(Session::class)->getMock(), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertFalse($user->login('incorrect', 'incorrect', '127.0.0.1'));
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginFailedIpNotWhitelisted()
    {
        $whitelist = $this->getMockBuilder(Whitelist::class)->getMock();
        $whitelist->method('isAllowed')->will($this->returnValue(false));

        $user = new User($this->getMockBuilder(Session::class)->getMock(), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertFalse($user->login('foo', 'bar', '127.0.0.1'));
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginSuccess()
    {
        $whitelist = $this->getMockBuilder(Whitelist::class)->getMock();
        $whitelist->method('isAllowed')->will($this->returnValue(true));

        $user = new User($this->getMockBuilder(Session::class)->getMock(), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertTrue($user->login('foo', 'bar', '127.0.0.1'));
    }
}
