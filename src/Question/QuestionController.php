<?php

namespace artes\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use artes\Tag\Tag;
use artes\Answer\Answer;
use artes\User\User;
use artes\QComment\QComment;
// use artes\Book\HTMLForm\CreateForm;
// use artes\Book\HTMLForm\EditForm;
// use artes\Book\HTMLForm\DeleteForm;
// use artes\Book\HTMLForm\UpdateForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

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
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->findAll();
        $res = $this->questToTag($questions);
        $mytags = $this->getTags($res);
        $page->add("question/overview", [
            "items" => $questions,
            "mytags" => $mytags
        ]);

        return $page->render([
            "title" => "A collection of questions",
        ]);
    }

    public function questToTag($questions) : array
    {
        $qht = new QuestionHasTag();
        $qht->setDb($this->di->get("dbqb"));
        $res = [];
        for ($i = 0; $i < count($questions); $i++) {
            $myvar = $qht->findAllWhere("questionid = ?", $questions[$i]->id);
            array_push($res, $myvar);
        }
        return $res;
    }

    public function getTags($res) : array
    {
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $mytags = [];
        for ($i = 0; $i < count($res); $i++) {
            $myarray = [];
            for ($j = 0; $j < count($res[$i]); $j++) {
                $myvar = $tag->find("id", $res[$i][$j]->tagid);
                array_push($myarray, $myvar->name);
            }
            array_push($mytags, implode(", ", $myarray));
        }
        return $mytags;
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
        $item = $this->getQuestion($nr);
        $answers = $this->getAnswers($item);
        $res = $this->questToTag([$item]);
        $mytags = $this->getTags($res);
        $user = $this->getUser($nr);
        $comments = $this->getQComment($nr);
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

    public function getAnswers($item) : array
    {
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllWhere("questionid = ?", $item->id);
        for ($i = 0; $i < count($answers); $i++) {
            $userid = $answers[$i]->userid;
            $answers[$i]->username = $this->getUser($userid)->name;
        }

        return $answers;
    }

    public function getQuestion($nr) : object
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $item = $question->find("id", $nr);
        return $item;
    }

    public function getUser($nr) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $item = $user->find("id", $nr);
        return $item;
    }

    public function getQComment($nr) : array
    {
        $qcomment = new QComment();
        $qcomment->setDb($this->di->get("dbqb"));
        $items = $qcomment->findAllWhere("questionid = ?", $nr);
        for ($i = 0; $i < count($items); $i++) {
            $userid = $items[$i]->userid;
            $items[$i]->username = $this->getUser($userid)->name;
        }
        return $items;
    }
}
