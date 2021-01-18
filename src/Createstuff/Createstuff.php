<?php

namespace artes\Createstuff;

use artes\AComment\AComment;
use artes\Answer\Answer;
use artes\Getstuff\Getstuff;
use artes\QComment\QComment;
use artes\Question\Question;
use artes\Question\QuestionHasTag;
use artes\User\User;
use artes\User\UserRatesAnswer;
use artes\User\UserRatesAComment;
use artes\User\UserRatesQComment;
use artes\User\UserRatesQuestion;

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

    public function saveAnswer($questionid, $userid, $textbody)
    {
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->userid = $userid;
        $answer->questionid = $questionid;
        $answer->textbody = htmlentities($textbody);
        $answer->rating = 0;
        $answer->accepted = 0;
        $answer->created = $this->centralEuropeanTime();
        $answer->updated = null;
        $answer->deleted = null;
        $answer->save();
    }

    public function saveAComment($answerid, $userid, $textbody)
    {
        $acomment = new AComment();
        $acomment->setDb($this->di->get("dbqb"));
        $acomment->userid = $userid;
        $acomment->answerid = $answerid;
        $acomment->textbody = htmlentities($textbody);
        $acomment->rating = 0;
        $acomment->created = $this->centralEuropeanTime();
        $acomment->updated = null;
        $acomment->deleted = null;
        $acomment->save();
    }

    public function saveQComment($questionid, $userid, $textbody)
    {
        $qcomment = new QComment();
        $qcomment->setDb($this->di->get("dbqb"));
        $qcomment->userid = $userid;
        $qcomment->questionid = $questionid;
        $qcomment->textbody = htmlentities($textbody);
        $qcomment->rating = 0;
        $qcomment->created = $this->centralEuropeanTime();
        $qcomment->updated = null;
        $qcomment->deleted = null;
        $qcomment->save();
    }

    public function saveQuestion($title, $textbody, $userid, $tags)
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->title = $title;
        $question->textbody = htmlentities($textbody);
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
        $questions = $getstuff->getQuestionsWhere("textbody = ?", htmlentities($textbody));
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

    public function saveUser($name, $email, $password)
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->email = $email;
        $user->password = md5($password);
        $user->name = $name;
        $user->gravatar = "https://www.gravatar.com/avatar/" . md5($email). "?s=32&d=identicon&r=PG";
        $user->rating = 0;
        $user->created = $this->centralEuropeanTime();
        $user->updated = null;
        $user->deleted = null;
        $user->save();
    }
}
