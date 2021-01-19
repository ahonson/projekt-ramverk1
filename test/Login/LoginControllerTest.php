<?php

namespace artes\Login;

use Anax\DI\DIFactoryConfig;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
  * A class for validating weather parameters.
  *
  * @SuppressWarnings(PHPMD)
  */
class LoginControllerTest extends TestCase
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
    public function testIndexActionGet()
    {
        $logincontroller = new LoginController();
        $res = $logincontroller->indexActionGet($this->di);
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }


    /**
     * Login
     */
    public function testErrMsg()
    {
        $logincontroller = new LoginController();
        $res = $logincontroller->errMsg("max", "min", "Pass123", "Pass123", $this->di);
        $this->assertEquals("Invalid e-mail", $res);
        $res1 = $logincontroller->errMsg("joe", "joe@joe.joe", "Pass123", "Pass123", $this->di);
        $this->assertEquals("This e-mail address is already taken.", $res1);
        $res2 = $logincontroller->errMsg("", "min@max.com", "Pass123", "Pass123", $this->di);
        $this->assertEquals("Invalid username", $res2);
        $res3 = $logincontroller->errMsg("max", "min@max.com", "Pass123", "Pass1323", $this->di);
        $this->assertEquals("The two passwords have to match.", $res3);
        $res4 = $logincontroller->errMsg("max", "min@max.com", "pass123", "pass123", $this->di);
        $this->assertEquals("The password has to contain at least 1 numeric, 1 uppercase and 1 lowercase character.", $res4);
        $res5 = $logincontroller->errMsg("max", "min@max.com", "Pass1", "Pass1", $this->di);
        $this->assertEquals("The password is too short", $res5);
        $res6 = $logincontroller->errMsg("max", "min@max.com", "Pass123", "Pass123", $this->di);
        $this->assertEquals("", $res6);
    }
}
