<?php

namespace artes\Createstuff;

use artes\User\UserRatesAnswer;
use artes\User\UserRatesQuestion;
use artes\User\UserRatesAComment;
use artes\User\UserRatesQComment;

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

    private function centralEuropeanTime()
    {
        $tz = 'Europe/Berlin';
        $timestamp = time();
        $dt = new \DateTime("now", new \DateTimeZone($tz)); //first argument "must" be a string
        $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
        return $dt->format('Y-m-d H:i:s');
    }

    public function saveUser()
    {

    }

    public function saveQuestion()
    {

    }

    public function saveAnswer()
    {

    }

    public function saveAComment()
    {

    }

    public function saveQComment()
    {

    }
}
