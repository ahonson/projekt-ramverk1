<?php

namespace artes\Createstuff;

use PHPUnit\Framework\TestCase;
use Anax\DI\DIFactoryConfig;

/**
  * A class for validating weather parameters.
  *
  * @SuppressWarnings(PHPMD)
  */
class CreatestuffTest extends TestCase
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
     * Getting CET
     */
    public function testCentralEuropeanTime()
    {
        $updatestuff = new Createstuff($this->di);
        $res = $updatestuff->centralEuropeanTime();
        $this->assertIsString($res);
        // $this->assertIsEqual(19, strlen($res));
    }
}
