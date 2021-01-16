<?php

namespace artes\Tag;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use artes\Getstuff\Getstuff;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class TagController implements ContainerInjectableInterface
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
        $page = $this->di->get("page");
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $data = [
            "src" => "img/theme/chesspieces1.png?width=1100&height=150&crop-to-fit&area=0,0,30,0",
        ];
        $page->add("anax/v2/image/default", $data, "flash");
        $page->add("tag/overview", [
            "items" => $tag->findAll(),
        ]);

        return $page->render([
            "title" => "A collection of tags",
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
    public function tagActionGet($nr, $mydi=null) : object
    {
        if ($mydi) {
            $this->di = $mydi;
        }
        $page = $this->di->get("page");
        $getstuff = new Getstuff($this->di);
        $tag = $getstuff->getTag($nr);
        $questions = $getstuff->tagToQuest($nr);
        $data = [
            "src" => "img/theme/chesspieces1.png?width=1100&height=150&crop-to-fit&area=0,0,30,0",
        ];
        $page->add("anax/v2/image/default", $data, "flash");
        $page->add("tag/tag", [
            "tag" => $tag,
            "questions" => $questions
        ]);

        return $page->render([
            "title" => "A question",
        ]);
    }
}
