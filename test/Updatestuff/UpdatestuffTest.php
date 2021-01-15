<?php

// namespace artes\Updatestuff;
//
// use PHPUnit\Framework\TestCase;
// use Anax\DI\DIFactoryConfig;

/**
  * A class for validating weather parameters.
  *
  * @SuppressWarnings(PHPMD)
  */
// class UpdatestuffTest extends TestCase
// {
//
//     protected $di;
//
//
//     /**
//      * Prepare before each test.
//      */
//     protected function setUp()
//     {
//         global $di;
//
//         // Setup di
//         $this->di = new DIFactoryConfig();
//         $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
//
//         // Use a different cache dir for unit test
//         $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
//
//         // View helpers uses the global $di so it needs its value
//         $di = $this->di;
//     }
//
//     /**
//      * Getstuff
//      */
//     public function testEditQuestion()
//     {
//         $rating = 8;
//         $questionid = 1;
//         $updatestuff = new Updatestuff($this->di);
//         $res = $updatestuff->editQuestion($rating, $questionid);
//         // sleep(5);
//         // $getstuff = new Getstuff($this->di);
//
//         // $res = $getstuff->getQuestion($questionid);
//         $this->assertIsObject($res);
//         $this->assertIsEqual($res->rating, $rating);
//     }
// }
