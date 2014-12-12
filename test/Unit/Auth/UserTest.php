<?php

namespace OpCacheGUITest\Unit\Auth;

use OpCacheGUI\Auth\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::isLoggedIn
     */
    public function testIsloggedInTrue()
    {
        $session = $this->getMock('\\OpCacheGUI\\Storage\\Session');
        $session->method('isKeyValid')->willReturn(true);

        $whitelist = $this->getMock('\\OpCacheGUI\\Auth\\Whitelist');

        $user = new User($session, 'user', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertTrue($user->isLoggedIn());
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::isLoggedIn
     */
    public function testIsloggedInFalse()
    {
        $session = $this->getMock('\\OpCacheGUI\\Storage\\Session');
        $session->method('isKeyValid')->willReturn(false);

        $whitelist = $this->getMock('\\OpCacheGUI\\Auth\\Whitelist');

        $user = new User($session, 'user', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertFalse($user->isLoggedIn());
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::requiresLogin
     */
    public function testRequiresLoginLoginNotEnabledInConfig()
    {
        $whitelist = $this->getMock('\\OpCacheGUI\\Auth\\Whitelist');

        $user = new User($this->getMock('\\OpCacheGUI\\Storage\\Session'), '', '', $whitelist);

        $this->assertFalse($user->requiresLogin());
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::isLoggedIn
     * @covers OpCacheGUI\Auth\User::requiresLogin
     */
    public function testRequiresLoginRequiredButNotLoggedIn()
    {
        $session = $this->getMock('\\OpCacheGUI\\Storage\\Session');
        $session->method('isKeyValid')->willReturn(false);

        $whitelist = $this->getMock('\\OpCacheGUI\\Auth\\Whitelist');

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
        $session = $this->getMock('\\OpCacheGUI\\Storage\\Session');
        $session->method('isKeyValid')->willReturn(true);

        $whitelist = $this->getMock('\\OpCacheGUI\\Auth\\Whitelist');

        $user = new User($session, 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertFalse($user->requiresLogin());
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginFailedIncorrectPassword()
    {
        $whitelist = $this->getMock('\\OpCacheGUI\\Auth\\Whitelist');
        $whitelist->method('isAllowed')->will($this->returnValue(true));

        $user = new User($this->getMock('\\OpCacheGUI\\Storage\\Session'), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertFalse($user->login('foo', 'nothashedbar', '127.0.0.1'));
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginFailedIncorrectUsername()
    {
        $whitelist = $this->getMock('\\OpCacheGUI\\Auth\\Whitelist');
        $whitelist->method('isAllowed')->will($this->returnValue(true));

        $user = new User($this->getMock('\\OpCacheGUI\\Storage\\Session'), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertFalse($user->login('incorrect', 'bar', '127.0.0.1'));
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginFailedIncorrectPasswordAndUsername()
    {
        $whitelist = $this->getMock('\\OpCacheGUI\\Auth\\Whitelist');
        $whitelist->method('isAllowed')->will($this->returnValue(true));

        $user = new User($this->getMock('\\OpCacheGUI\\Storage\\Session'), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertFalse($user->login('incorrect', 'incorrect', '127.0.0.1'));
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginFailedIpNotWhitelisted()
    {
        $whitelist = $this->getMock('\\OpCacheGUI\\Auth\\Whitelist');
        $whitelist->method('isAllowed')->will($this->returnValue(false));

        $user = new User($this->getMock('\\OpCacheGUI\\Storage\\Session'), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertFalse($user->login('foo', 'bar', '127.0.0.1'));
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginSuccess()
    {
        $whitelist = $this->getMock('\\OpCacheGUI\\Auth\\Whitelist');
        $whitelist->method('isAllowed')->will($this->returnValue(true));

        $user = new User($this->getMock('\\OpCacheGUI\\Storage\\Session'), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q', $whitelist);

        $this->assertTrue($user->login('foo', 'bar', '127.0.0.1'));
    }
}
