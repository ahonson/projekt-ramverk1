<?php

namespace artes\Getstuff;

use artes\Tag\Tag;
use artes\Answer\Answer;
use artes\User\User;
use artes\Question\Question;
use artes\Question\QuestionHasTag;
use artes\QComment\QComment;
use artes\AComment\AComment;


/**
  * A class for getting stuff from the db.
  *
  * @SuppressWarnings(PHPMD)
  */
class Getstuff
{

    private $di;

    public function __construct($di)
    {
        $this->di = $di;
    }

    private function addInfo($object) : object
    {
        $textbody = $object->textbody;
        $object->info = $textbody;
        if (count(explode(" ", $textbody)) > 5) {
            $info = array_slice(explode(" ", $textbody), 0, 5);
            $object->info = implode(" ", $info) . "...";
        }
        return $object;
    }

    public function getAllAnswersWhere($nr) : array
    {
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllWhere("userid = ?", $nr);
        for ($i = 0; $i < count($answers); $i++) {
            $answers[$i] = $this->addInfo($answers[$i]);
        }
        return $answers;
    }

    public function getAnswer($nr) : object
    {
        $ans = new Answer();
        $ans->setDb($this->di->get("dbqb"));
        $answer = $ans->find("id", $nr);
        return $answer;
    }

    public function getAnswers($id) : array
    {
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllWhere("questionid = ?", $id);
        for ($i = 0; $i < count($answers); $i++) {
            $userid = $answers[$i]->userid;
            $answers[$i]->username = $this->getUser($userid)->name;
            $answers[$i]->userid = $this->getUser($userid)->id;
            $answers[$i]->comments = $this->getComments($answers[$i]->id, "a");
        }

        return $answers;
    }

    public function getComment($nr, $type="q") : object
    {
        if ($type === "a") {
            $comment = new AComment();
        } else {
            $comment = new QComment();
        }
        $comment->setDb($this->di->get("dbqb"));
        $item = $comment->find("id", $nr);
        return $item;
    }

    public function getComments($nr, $type="q") : array
    {
        if ($type === "q") {
            $comment = new QComment();
            $search = "questionid = ?";
        } elseif ($type === "a") {
            $comment = new AComment();
            $search = "answerid = ?";
        } else {
            return [];
        }
        $comment->setDb($this->di->get("dbqb"));
        $items = $comment->findAllWhere($search, $nr);
        for ($i = 0; $i < count($items); $i++) {
            $userid = $items[$i]->userid;
            $items[$i]->username = $this->getUser($userid)->name;
            $items[$i]->userid = $userid;
        }
        return $items;
    }

    public function getAllCommentsWhere($nr) : array
    {
        $qcomment = new QComment();
        $acomment = new AComment();
        $search = "userid = ?";

        $qcomment->setDb($this->di->get("dbqb"));
        $qitems = $qcomment->findAllWhere($search, $nr);
        for ($i = 0; $i < count($qitems); $i++) {
            $userid = $qitems[$i]->userid;
            $qitems[$i]->username = $this->getUser($userid)->name;
            $qitems[$i] = $this->addInfo($qitems[$i]);
        }

        $acomment->setDb($this->di->get("dbqb"));
        $aitems = $acomment->findAllWhere($search, $nr);
        for ($i = 0; $i < count($aitems); $i++) {
            $userid = $aitems[$i]->userid;
            $aitems[$i]->username = $this->getUser($userid)->name;
            $ans = $this->getAnswer($aitems[$i]->answerid);
            $aitems[$i]->questionid = $ans->id;
            $aitems[$i] = $this->addInfo($aitems[$i]);
        }
        return array_merge($aitems, $qitems);
    }

    public function getQuestion($nr) : object
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $item = $question->find("id", $nr);
        $res = $this->questToTag([$item]);
        $item->tags = $this->getTags($res, false)[0];
        return $item;
    }

    public function getQuestions() : array
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $item = $question->findAll();
        return $item;
    }

    public function getQuestionsWhere($search, $nr) : array
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $item = $question->findAllWhere($search, $nr);
        return $item;
    }

    public function getTag($nr) : object
    {
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $item = $tag->find("id", $nr);
        return $item;
    }

    public function getTags($res, $str=true) : array
    {
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $mytags = [];
        for ($i = 0; $i < count($res); $i++) {
            $myarray = [];
            for ($j = 0; $j < count($res[$i]); $j++) {
                $myvar = $tag->find("id", $res[$i][$j]->tagid);
                $myarray[$res[$i][$j]->tagid] = $myvar->name;
            }
            if ($str) {
                array_push($mytags, implode(", ", $myarray));
            } else {
                array_push($mytags, $myarray);
            }
        }
        return $mytags;
    }

    public function getUser($nr) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $item = $user->find("id", $nr);
        return $item;
    }

    public function getUsers() : array
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $item = $user->findAll();
        return $item;
    }

    public function questToTag($questions, $search="questionid = ?") : array
    {
        $qht = new QuestionHasTag();
        $qht->setDb($this->di->get("dbqb"));
        $res = [];
        for ($i = 0; $i < count($questions); $i++) {
            $myvar = $qht->findAllWhere($search, $questions[$i]->id);
            array_push($res, $myvar);
        }
        return $res;
    }

    public function tagToQuest($nr) : array
    {
        $qht = new QuestionHasTag();
        $qht->setDb($this->di->get("dbqb"));
        $matches = $qht->findAllWhere("tagid = ?", $nr);
        $res = [];
        for ($i = 0; $i < count($matches); $i++) {
            $myvar = $this->getQuestion($matches[$i]->questionid);
            array_push($res, $myvar);
        }
        return $res;
    }
}
