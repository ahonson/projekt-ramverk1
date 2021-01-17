<?php

namespace artes\Index;

use Anax\DI\DIFactoryConfig;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;


/**
  * A class for validating weather parameters.
  *
  * @SuppressWarnings(PHPMD)
  */
class IndexControllerTest extends TestCase
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
        $getstuff = new IndexController();
        // var_dump($this->di);
        $res = $getstuff->indexActionGet($this->di);
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
}
