<?php

namespace artes\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use artes\Getstuff\Getstuff;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $getstuff = new Getstuff($this->di);
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->findAll();
        $res = $getstuff->questToTag($questions);
        $mytags = $getstuff->getTags($res);
        $page->add("question/overview", [
            "items" => $questions,
            "mytags" => $mytags
        ]);

        return $page->render([
            "title" => "A collection of questions",
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function questionActionGet($nr) : object
    {
        $page = $this->di->get("page");
        $getstuff = new Getstuff($this->di);
        $item = $getstuff->getQuestion($nr);
        $answers = $getstuff->getAnswers($item->id);
        $res = $getstuff->questToTag([$item]);
        $mytags = $getstuff->getTags($res);
        $user = $getstuff->getUser($nr);
        $comments = $getstuff->getComment($nr);
        $page->add("question/question", [
            "item" => $item,
            "mytags" => $mytags,
            "answers" => $answers,
            "user" => $user,
            "comments" => $comments
        ]);

        return $page->render([
            "title" => "A question",
        ]);
    }
}
