<?php

namespace artes\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use artes\Tag\Tag;
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
        $qht = new QuestionHasTag();
        $qht->setDb($this->di->get("dbqb"));
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $res = [];
        for ($i = 0; $i < count($questions); $i++) {
            $myvar = $qht->findAllWhere("questionid = ?", $questions[$i]->id);
            array_push($res, $myvar);
        }
        $mytags = [];
        for ($i = 0; $i < count($res); $i++) {
            $myarray = [];
            for ($j = 0; $j < count($res[$i]); $j++) {
                $myvar = $tag->find("id", $res[$i][$j]->tagid);
                array_push($myarray, $myvar->name);
            }
            array_push($mytags, implode(", ", $myarray));
        }

        $page->add("question/overview", [
            "items" => $questions,
            // "res" => $res,
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
        $question = new Question();
        $tag = new Tag();
        $question->setDb($this->di->get("dbqb"));

        $page->add("question/question", [
            "item" => $question->find("id", $nr),
            // "tags" = > $tag->findAll();
        ]);

        return $page->render([
            "title" => "A question",
        ]);
    }
}
