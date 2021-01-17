<?php

namespace Anax\Controller;
namespace artes\Index;

use Anax\Route\Exception\NotFoundException;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use artes\Getstuff\Getstuff;
use artes\Createstuff\Createstuff;
use artes\Updatestuff\Updatestuff;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class IndexController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

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
        $data = [
            "src" => "img/theme/chesspieces1.png?width=1100&height=150&crop-to-fit&area=0,0,30,0",
        ];
        // $getstuff = new Getstuff($this->di);
        // $mytag = $getstuff->trytags(4);

        $this->di->get("dbqb")->connect();
        $sql = "SELECT *, COUNT(name) AS ct FROM Tag AS t, QuestionHasTag AS qht WHERE t.id = qht.tagid GROUP BY name ORDER BY ct DESC LIMIT 3;";
        $top3tags = $this->di->dbqb->executeFetchAll($sql);

        $sql = "SELECT * FROM Question ORDER BY created DESC LIMIT 3;";
        $top3questions = $this->di->dbqb->executeFetchAll($sql);
        $getstuff = new Getstuff($this->di);
        $res = $getstuff->questToTag($top3questions);
        $mytags = $getstuff->getTags($res);

        $top3users = $getstuff->getTopUsers(3);
        // $sql = "";
        // $top3users = $this->di->dbqb->executeFetchAll($sql);
        // var_dump($top3users);
        // die(",,,,,,,,,,,,,,,,");

        $page = $this->di->get("page");
        $page->add("anax/v2/image/default", $data, "flash");
        $page->add("index/index", [
            // "top3tags" => $top3tags
        ]);
        $page->add("index/topquestions", [
            "top3questions" => $top3questions,
            "mytags" => $mytags
        ]);
        $page->add("index/toptags", [
            "top3tags" => $top3tags
        ], "sidebar-right");
        $page->add("index/topusers", [
            "top3users" => $top3users
        ]);

        return $page->render([
            "title" => "A collection of questions",
        ]);
    }
}
