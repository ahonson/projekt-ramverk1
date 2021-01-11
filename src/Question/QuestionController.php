<?php

namespace artes\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
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
        // $book = new Book();
        // $book->setDb($this->di->get("dbqb"));

        $page->add("question/overview");

        return $page->render([
            "title" => "A collection of items",
        ]);
    }
}
