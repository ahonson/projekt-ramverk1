<?php

namespace artes\Profile;

use Anax\DI\DIFactoryConfig;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;
// use artes\Login\Login;


/**
  * A class for validating weather parameters.
  *
  * @SuppressWarnings(PHPMD)
  */
class ProfileControllerTest extends TestCase
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
     * Getstuff
     */
    public function testIndexActionGet()
    {
        $profilecontroller = new ProfileController();
        $res = $profilecontroller->indexActionGet($this->di);

        // $login = new Login();
        // $getstuff = new Getstuff($this->di);
        // $users = $getstuff->getUsers();
        // $data = [
        //     "users" => $users,
        //     "email" => "joe@joe.joe",
        //     "password" => "Joe123"
        // ];
        // $login->loginSuccess($data);
        //
        // $data = [
        //     "users" => $users,
        //     "email" => "joe@joe.joe",
        //     "password" => "Joe12"
        // ];
        // $login->loginSuccess($data);
        //
        // $this->di->request->setGlobals([
        //     "session" => [
        //         "userLoginStatus" => $login
        //     ]
        // ]);

        // $res1 = $profilecontroller->indexActionGet($this->di);
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testPlural()
    {
        $profilecontroller = new ProfileController();
        $res = $profilecontroller->plural(3, 1, 1, 0, 3);
        $res1 = $profilecontroller->plural(1, 3, 1, 0, 3);
        $this->assertIsArray($res);
        $this->assertIsArray($res1);
    }
}
