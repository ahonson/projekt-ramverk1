<?php

namespace artes\Getstuff;

use PHPUnit\Framework\TestCase;
use Anax\DI\DIFactoryConfig;

/**
  * A class for validating weather parameters.
  *
  * @SuppressWarnings(PHPMD)
  */
class GetstuffTest extends TestCase
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
    public function testGetAllAnswersWhere()
    {
        $getstuff = new Getstuff($this->di);
        $res = $getstuff->getAllAnswersWhere("blabla");
        $res1 = $getstuff->getAllAnswersWhere(2);
        $this->assertIsArray($res);
        $this->assertEmpty($res);
        $this->assertNotEmpty($res1);
    }

    /**
     * Getstuff
     */
    public function testGetAnswer()
    {
        $getstuff = new Getstuff($this->di);
        $res = $getstuff->getAnswer(1);
        $this->assertIsObject($res);
        $this->assertObjectHasAttribute("accepted", $res);
    }


    /**
     * Getstuff
     */
    public function testGetAnswers()
    {
        $getstuff = new Getstuff($this->di);
        $res = $getstuff->getAnswers(1);
        $res1 = $getstuff->getAnswers("blabla");
        $this->assertIsArray($res);
        $this->assertNotEmpty($res);
        $this->assertEmpty($res1);
    }

    /**
     * Getstuff
     */
    public function testGetComments()
    {
        $getstuff = new Getstuff($this->di);
        $res = $getstuff->getComments(1);
        $res1 = $getstuff->getComments(1, "bla");
        $this->assertIsArray($res);
        $this->assertNotEmpty($res);
        $this->assertEmpty($res1);
    }

    /**
     * Getstuff
     */
    public function testGetAllCommentsWhere()
    {
        $getstuff = new Getstuff($this->di);
        $res = $getstuff->getAllCommentsWhere("blabla");
        $res1 = $getstuff->getAllCommentsWhere(3);
        $this->assertIsArray($res);
        $this->assertEmpty($res);
        $this->assertNotEmpty($res1);
    }

    /**
     * Getstuff
     */
    public function testGetQuestion()
    {
        $getstuff = new Getstuff($this->di);
        $res = $getstuff->getQuestion(1);
        $this->assertIsObject($res);
        $this->assertObjectHasAttribute("title", $res);
    }

    /**
     * Getstuff
     */
    public function testGetQuestions()
    {
        $getstuff = new Getstuff($this->di);
        $res = $getstuff->getQuestions();
        $this->assertIsArray($res);
        $this->assertNotEmpty($res);
    }

    /**
     * Getstuff
     */
    public function testGetQuestionsWhere()
    {
        $getstuff = new Getstuff($this->di);
        $res = $getstuff->getQuestionsWhere("userid = ?", 1);
        $this->assertIsArray($res);
        $this->assertNotEmpty($res);
    }

    /**
     * Getstuff
     */
    public function testGetTag()
    {
        $getstuff = new Getstuff($this->di);
        $res = $getstuff->getTag(1);
        $this->assertIsObject($res);
    }


    /**
     * Getstuff
     */
    public function testGetTags()
    {
        $getstuff = new Getstuff($this->di);
        $item = $getstuff->getQuestion(1);
        $answers = $getstuff->getAnswers($item->id);
        $matches = $getstuff->questToTag([$item]);
        $res = $getstuff->getTags($matches);
        $this->assertIsArray($res);
        $this->assertNotEmpty($res);
    }

    /**
     * Getstuff
     */
    public function testGetUsers()
    {
        $getstuff = new Getstuff($this->di);
        $res = $getstuff->getUsers();
        $this->assertIsArray($res);
        $this->assertNotEmpty($res);
    }

    /**
     * Getstuff
     */
    public function testTagToQuest()
    {
        $getstuff = new Getstuff($this->di);
        $res = $getstuff->tagToQuest(3);
        $this->assertIsArray($res);
        $this->assertNotEmpty($res);
    }
}
