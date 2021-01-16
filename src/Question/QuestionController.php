<?php

namespace Anax\Controller;
namespace artes\Question;

use Anax\Route\Exception\NotFoundException;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use artes\Getstuff\Getstuff;
use artes\Createstuff\Createstuff;
use artes\Updatestuff\Updatestuff;

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
    public function indexActionGet($mydi=null) : object
    {
        if ($mydi) {
            $this->di = $mydi;
        }
        $page = $this->di->get("page");
        $getstuff = new Getstuff($this->di);
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->findAll();
        $res = $getstuff->questToTag($questions);
        $mytags = $getstuff->getTags($res);
        $data = [
            "src" => "img/theme/chesspieces1.png?width=1100&height=150&crop-to-fit&area=0,0,30,0",
        ];
        $page->add("anax/v2/image/default", $data, "flash");
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
    public function questionActionGet($nr, $mydi=null) : object
    {
        if ($mydi) {
            $this->di = $mydi;
        }
        $page = $this->di->get("page");
        $getstuff = new Getstuff($this->di);
        $item = $getstuff->getQuestion($nr);
        $answers = $getstuff->getAnswers($item->id);
        $res = $getstuff->questToTag([$item]);
        $mytags = $getstuff->getTags($res);
        $user = $getstuff->getUser($nr);
        $comments = $getstuff->getComments($nr);
        $data = [
            "src" => "img/theme/chesspieces1.png?width=1100&height=150&crop-to-fit&area=0,0,30,0",
        ];
        $page->add("anax/v2/image/default", $data, "flash");
        $page->add("question/question", [
            "item" => $item,
            "mytags" => $mytags,
            "answers" => $answers,
            "user" => $user,
            "comments" => $comments,
            "loginid" => 4
        ]);

        return $page->render([
            "title" => "A question",
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
    public function newquestionActionGet($mydi=null) : object
    {
        if ($mydi) {
            $this->di = $mydi;
        }
        $page = $this->di->get("page");
        $getstuff = new Getstuff($this->di);
        $tags = $getstuff->getAllTags();
        $data = [
            "src" => "img/theme/chesspieces1.png?width=1100&height=150&crop-to-fit&area=0,0,30,0",
        ];
        $page->add("anax/v2/image/default", $data, "flash");
        $page->add("question/newquestion", [
            "title" => "",
            "textbody" => "",
            "tags" => $tags,
        ]);

        return $page->render([
            "title" => "A new question",
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
    public function questionActionPost($nr) : object
    {
        $request = $this->di->request;
        $createstuff = new Createstuff($this->di);
        $editstuff = new Updatestuff($this->di);
        $list = explode(";", $request->getPost("data", null));
        // [0] value, [1] textid, [2] userid, [3] scroll position
        $ratequestion = $request->getPost("ratequestion", null);
        if ($ratequestion === "") {
            $createstuff->saveQuestionRating($list[0], $list[1], $list[2]);
            $editstuff->editQuestion($list[0], $list[1]);
        }
        $rateqcomment = $request->getPost("rateqcomment", null);
        if ($rateqcomment === "") {
            $createstuff->saveQCommentRating($list[0], $list[1], $list[2]);
            $editstuff->editQComment($list[0], $list[1]);
        }
        $rateanswer = $request->getPost("rateanswer", null);
        if ($rateanswer === "") {
            $createstuff->saveAnswerRating($list[0], $list[1], $list[2]);
            $editstuff->editAnswer($list[0], $list[1]);
        }
        $rateacomment = $request->getPost("rateacomment", null);
        if ($rateacomment === "") {
            $createstuff->saveACommentRating($list[0], $list[1], $list[2]);
            $editstuff->editAComment($list[0], $list[1]);
        }

        $sendanswer = $request->getPost("sendanswer", null);
        if ($sendanswer) {
            $textbody = $request->getPost("answertext");
            $createstuff->saveAnswer($list[1], $list[2], $textbody);
        }

        $sendacomment = $request->getPost("sendacomment", null);
        if ($sendacomment) {
            $textbody = $request->getPost("acommenttext");
            $createstuff->saveAComment($list[1], $list[2], $textbody);
        }

        $sendqcomment = $request->getPost("sendqcomment", null);
        if ($sendqcomment) {
            $textbody = $request->getPost("qcommenttext");
            $createstuff->saveQComment($list[1], $list[2], $textbody);
        }

        $response = $this->di->response;
        return $response->redirect("question/question/" . $nr . "#" . $list[3]);
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function newquestionActionPost() : object
    {
        $request = $this->di->request;
        $response = $this->di->response;

        $createstuff = new Createstuff($this->di);
        $title = $request->getPost("title");
        $textbody = $request->getPost("textbody");
        $userid = 3;
        $tags = [];
        if(!empty($request->getPost("tagname"))) {
            foreach($request->getPost("tagname") as $tagname) {
                array_push($tags, $tagname);
            }
        }
        if (!$title || !$textbody || !$tags) {
            return $response->redirect("question/newquestion");
        } else {
            $createstuff->saveQuestion($title, $textbody, $userid, $tags);
            return $response->redirect("question/");
        }
    }
}
