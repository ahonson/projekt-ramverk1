<?php

namespace artes\Createstuff;

use artes\User\UserRatesAnswer;
use artes\User\UserRatesQuestion;
use artes\User\UserRatesAComment;
use artes\User\UserRatesQComment;
use artes\Question\Question;
use artes\Question\QuestionHasTag;
use artes\Getstuff\Getstuff;

/**
  * A class for adding stuff to the db.
  *
  * @SuppressWarnings(PHPMD)
  */
class Createstuff
{
    private $di;

    public function __construct($di)
    {
        $this->di = $di;
    }

    public function saveAnswerRating($up, $answerid, $userid)
    {
        $ura = new UserRatesAnswer();
        $ura->setDb($this->di->get("dbqb"));
        $ura->up = $up;
        $ura->answerid = $answerid;
        $ura->userid = $userid;
        $ura->created = $this->centralEuropeanTime();
        $ura->save();
    }

    public function saveACommentRating($up, $commentid, $userid)
    {
        $urac = new UserRatesAComment();
        $urac->setDb($this->di->get("dbqb"));
        $urac->up = $up;
        $urac->commentid = $commentid;
        $urac->userid = $userid;
        $urac->created = $this->centralEuropeanTime();
        $urac->save();
    }

    public function saveQCommentRating($up, $commentid, $userid)
    {
        $urqc = new UserRatesQComment();
        $urqc->setDb($this->di->get("dbqb"));
        $urqc->up = $up;
        $urqc->commentid = $commentid;
        $urqc->userid = $userid;
        $urqc->created = $this->centralEuropeanTime();
        $urqc->save();
    }

    public function saveQuestionRating($up, $questionid, $userid)
    {
        $urq = new UserRatesQuestion();
        $urq->setDb($this->di->get("dbqb"));
        $urq->up = $up;
        $urq->questionid = $questionid;
        $urq->userid = $userid;
        $urq->created = $this->centralEuropeanTime();
        $urq->save();
    }

    public function centralEuropeanTime()
    {
        $tz = 'Europe/Berlin';
        $timestamp = time();
        $dt = new \DateTime("now", new \DateTimeZone($tz)); //first argument "must" be a string
        $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
        return $dt->format('Y-m-d H:i:s');
    }

    // public function saveAnswer()
    // {
    //
    // }
    //
    // public function saveAComment()
    // {
    //
    // }
    //
    // public function saveQComment()
    // {
    //
    // }

    public function saveQuestion($title, $textbody, $userid, $tags)
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->title = $title;
        $question->textbody = $textbody;
        $question->userid = $userid;
        $question->rating = 0;
        $question->created = $this->centralEuropeanTime();
        $question->updated = null;
        $question->deleted = null;
        $question->save();
        $this->saveQuest2Tag($tags, $textbody); // $tags is an array of tagids
    }

    public function saveQuest2Tag($tags, $textbody)
    {
        $getstuff = new Getstuff($this->di);
        $questions = $getstuff->getQuestionsWhere("textbody = ?", $textbody);
        $id = 1;
        for ($i=0; $i < count($questions); $i++) {
            $id = $questions[$i]->id;
        }
        for ($i=0; $i < count($tags); $i++) {
            $q2t = new QuestionHasTag();
            $q2t->setDb($this->di->get("dbqb"));
            $q2t->questionid = $id;
            $q2t->tagid = $tags[$i];
            $q2t->save();
            echo ";";
        }
    }

    // public function saveUser()
    // {
    //
    // }
}
