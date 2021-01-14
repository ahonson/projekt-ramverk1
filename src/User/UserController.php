<?php

namespace artes\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use artes\Getstuff\Getstuff;
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
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     ;
    // }



    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet($mydi=null) : object
    {
        if ($mydi) {
            $this->di = $mydi;
        }
        $page = $this->di->get("page");
        $getstuff = new Getstuff($this->di);
        $users = $getstuff->getUsers();
        $page->add("user/overview", [
            "items" => $users
        ]);

        return $page->render([
            "title" => "A collection of users",
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
    public function userActionGet($nr, $mydi=null) : object
    {
        if ($mydi) {
            $this->di = $mydi;
        }
        $page = $this->di->get("page");
        $getstuff = new Getstuff($this->di);
        // $item = $this->getQuestion($nr);
        $questions = $getstuff->getQuestionsWhere("userid = ?", $nr);
        $res = $getstuff->questToTag($questions);
        $mytags = $getstuff->getTags($res);
        $user = $getstuff->getUser($nr);
        $allcomments = $getstuff->getAllCommentsWhere($nr);
        $allanswers = $getstuff->getAllAnswersWhere($nr);
        $page->add("user/user", [
            "allanswers" => $allanswers,
            "mytags" => $mytags,
            "items" => $questions,
            "user" => $user,
            "allcomments" => $allcomments
        ]);

        return $page->render([
            "title" => "A question",
        ]);
    }
}
