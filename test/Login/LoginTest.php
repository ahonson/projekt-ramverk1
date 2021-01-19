<?php

namespace artes\Login;

use PHPUnit\Framework\TestCase;
use Anax\DI\DIFactoryConfig;
use artes\Getstuff\Getstuff;

/**
  * A class for validating weather parameters.
  *
  * @SuppressWarnings(PHPMD)
  */
class LoginTest extends TestCase
{

    protected $di;


    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;
    }

    /**
     * Login
     */
    public function testLoginSuccess()
    {
        $login = new Login();
        $getstuff = new Getstuff($this->di);
        $users = $getstuff->getUsers();
        $data = [
            "users" => $users,
            "email" => "joe@joe.joe",
            "password" => "Joe123"
        ];
        $res = $login->loginSuccess($data);
        $data = [
            "users" => $users,
            "email" => "joe@joe.joe",
            "password" => "Joe12"
        ];
        $res1 = $login->loginSuccess($data);

        $this->assertTrue($res);
        $this->assertFalse($res1);
    }


    /**
     * Login
     */
    public function testIsLoggedIn()
    {
        $login = new Login();
        $getstuff = new Getstuff($this->di);
        $users = $getstuff->getUsers();
        $data = [
            "users" => $users,
            "email" => "joe@joe.joe",
            "password" => "Joe123"
        ];
        $login->loginSuccess($data);
        $res = $login->isLoggedIn();
        $login->logout();
        $res1 = $login->isLoggedIn();

        $this->assertTrue($res);
        $this->assertFalse($res1);
    }
}
