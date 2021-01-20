<?php

namespace artes\Getstuff;

use artes\Tag\Tag;
use artes\Answer\Answer;
use artes\User\User;
use artes\Question\Question;
use artes\Question\QuestionHasTag;
use artes\QComment\QComment;
use artes\AComment\AComment;
use artes\User\UserRatesAnswer;
use artes\User\UserRatesQuestion;
use artes\User\UserRatesAComment;
use artes\User\UserRatesQComment;


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

    // public function trytags($nr) : array
    // {
    //     $tag = new Tag();
    //     $tag->setDb($this->di->get("dbqb"));
    //     $res = $tag->execute("SELECT * FROM Tag WHERE id = $nr");
    //     return $res;
    // }

    public function getAllAnswersWhere($nr, $search="userid = ?") : array
    {
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllWhere($search, $nr);
        $answerlength = count($answers);
        for ($i = 0; $i < $answerlength; $i++) {
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
        $answerlength = count($answers);
        for ($i = 0; $i < $answerlength; $i++) {
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
        $itemlength = count($items);
        for ($i = 0; $i < $itemlength; $i++) {
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
        $qitemlength = count($qitems);
        for ($i = 0; $i < $qitemlength; $i++) {
            $userid = $qitems[$i]->userid;
            $qitems[$i]->username = $this->getUser($userid)->name;
            $qitems[$i] = $this->addInfo($qitems[$i]);
        }

        $acomment->setDb($this->di->get("dbqb"));
        $aitems = $acomment->findAllWhere($search, $nr);
        $aitemlength = count($aitems);
        for ($i = 0; $i < $aitemlength; $i++) {
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
        $items = $question->findAll();
        $itemlength = count($items);
        for ($i=0; $i < $itemlength; $i++) {
            $answers = $this->getAnswers($items[$i]->id);
            $items[$i]->answercount = count($answers);
        }
        return $items;
    }

    public function getQuestionsWhere($search, $nr) : array
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $item = $question->findAllWhere($search, $nr);
        return $item;
    }

    public function getAllTags() : array
    {
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $item = $tag->findAll();
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
        $reslength = count($res);
        for ($i = 0; $i < $reslength; $i++) {
            $myarray = [];
            $sublength = count($res[$i]);
            for ($j = 0; $j < $sublength; $j++) {
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

    public function getTopUsers($limit) : array
    {
        $users = $this->getUsers();
        $userlength = count($users);
        for ($i=0; $i < $userlength; $i++) {
            $questions = $this->getQuestionsWhere("userid = ?", $users[$i]->id);
            $allcomments = $this->getAllCommentsWhere($users[$i]->id);
            $allanswers = $this->getAllAnswersWhere($users[$i]->id);
            $users[$i]->questions = count($questions);
            $users[$i]->comments = count($allcomments);
            $users[$i]->answers = count($allanswers);
            $users[$i]->total = count($questions) + count($allcomments) + count($allanswers);
        }
        usort($users, function($first, $second) {
            return $first->total < $second->total;
        });
        return array_slice($users, 0, $limit);
    }

    public function getUser($nr, $category="id") : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $item = $user->find($category, $nr);
        return $item;
    }

    public function getUserExtra($value, $category="id") : object
    {
        $user = $this->getUser($value, $category);
        $questions = $this->getQuestionsWhere("userid = ?", $user->id);
        $allcomments = $this->getAllCommentsWhere($user->id);
        $allanswers = $this->getAllAnswersWhere($user->id);
        $acceptedanswers = $this->getAllAnswersWhere($user->id, "userid = ? AND accepted = 1");
        $user->questions = count($questions);
        $user->comments = count($allcomments);
        $user->answers = count($allanswers);
        $user->accepted = count($acceptedanswers);
        $user->up = $this->getVotes($user->id, true);
        $user->down = $this->getVotes($user->id, false);
        return $user;
    }

    public function getUsers() : array
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $item = $user->findAll();
        return $item;
    }

    public function getVotes($userid, $up=true) : int
    {
        if ($up) {
            $search = "userid = ? AND up = 1";
        } else {
            $search = "userid = ? AND up = -1";
        }
        $urq = new UserRatesQuestion();
        $ura = new UserRatesAnswer();
        $urac = new UserRatesAComment();
        $urqc = new UserRatesQComment();
        $urq->setDb($this->di->get("dbqb"));
        $ura->setDb($this->di->get("dbqb"));
        $urac->setDb($this->di->get("dbqb"));
        $urqc->setDb($this->di->get("dbqb"));
        $urqcount = count($urq->findAllWhere($search, $userid));
        $uracount = count($ura->findAllWhere($search, $userid));
        $uraccount = count($urac->findAllWhere($search, $userid));
        $urqccount = count($urqc->findAllWhere($search, $userid));
        return ($urqcount + $uracount + $uraccount + $urqccount);
    }

    public function questToTag($questions, $search="questionid = ?") : array
    {
        $qht = new QuestionHasTag();
        $qht->setDb($this->di->get("dbqb"));
        $res = [];
        $questionlength = count($questions);
        for ($i = 0; $i < $questionlength; $i++) {
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
        $matchlength = count($matches);
        for ($i = 0; $i < $matchlength; $i++) {
            $myvar = $this->getQuestion($matches[$i]->questionid);
            array_push($res, $myvar);
        }
        return $res;
    }
}
