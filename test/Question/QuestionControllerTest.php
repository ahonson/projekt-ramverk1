<?php

namespace artes\Question;

use Anax\DI\DIFactoryConfig;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;


/**
  * A class for validating weather parameters.
  *
  * @SuppressWarnings(PHPMD)
  */
class QuestionControllerTest extends TestCase
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
        $getstuff = new QuestionController();
        // var_dump($this->di);
        $res = $getstuff->indexActionGet($this->di);
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Getstuff
     */
    public function testQuestionActionGet()
    {
        $getstuff = new QuestionController();
        $res = $getstuff->questionActionGet(1, $this->di);
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }


    /**
     * Getstuff
     */
    // public function testQuestionActionPost()
    // {
    //     $getstuff = new QuestionController();
    //     $getstuff->setDI($this->di);
    //
    //     $request = $this->di->get("request");
    //     $request->setGlobals([
    //         "post" => [
    //             "data" => "1;1;2;#questionid-1",
    //             "ratequestion" => ""
    //         ],
    //     ]);
    //
    //     // var_dump($this->di);
    //     // die();
    //     $res = $getstuff->questionActionPost(1, $this->di);
    //     // $res = $getstuff->questionActionPost(1);
    //     $this->assertInstanceOf(ResponseUtility::class, $res);
    // }
}
