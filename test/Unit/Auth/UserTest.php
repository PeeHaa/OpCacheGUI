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

        $user = new User($session, 'user', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q');

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

        $user = new User($session, 'user', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q');

        $this->assertFalse($user->isLoggedIn());
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::requiresLogin
     */
    public function testRequiresLoginLoginNotEnabledInConfig()
    {
        $user = new User($this->getMock('\\OpCacheGUI\\Storage\\Session'), '', '');

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

        $user = new User($session, 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q');

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

        $user = new User($session, 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q');

        $this->assertFalse($user->requiresLogin());
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginFailedIncorrectPassword()
    {
        $user = new User($this->getMock('\\OpCacheGUI\\Storage\\Session'), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q');

        $this->assertFalse($user->login('foo', 'nothashedbar'));
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginFailedIncorrectUsername()
    {
        $user = new User($this->getMock('\\OpCacheGUI\\Storage\\Session'), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q');

        $this->assertFalse($user->login('incorrect', 'bar'));
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginFailedIncorrectPasswordAndUsername()
    {
        $user = new User($this->getMock('\\OpCacheGUI\\Storage\\Session'), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q');

        $this->assertFalse($user->login('incorrect', 'incorrect'));
    }

    /**
     * @covers OpCacheGUI\Auth\User::__construct
     * @covers OpCacheGUI\Auth\User::login
     */
    public function testLoginSuccess()
    {
        $user = new User($this->getMock('\\OpCacheGUI\\Storage\\Session'), 'foo', '$2y$14$Gh5y/MR130J3V1xhH5eGWOvpTMgLu9Er82o3ZNrhxMuyZm6Sdx96q');

        $this->assertTrue($user->login('foo', 'bar'));
    }
}
