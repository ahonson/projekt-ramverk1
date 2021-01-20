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
        $ura->answerid = $answerid;
        $this->ratingSave($ura, $userid, $up);
    }

    public function saveACommentRating($up, $commentid, $userid)
    {
        $urac = new UserRatesAComment();
        $urac->commentid = $commentid;
        $this->ratingSave($urac, $userid, $up);
    }

    public function saveQCommentRating($up, $commentid, $userid)
    {
        $urqc = new UserRatesQComment();
        $urqc->commentid = $commentid;
        $this->ratingSave($urqc, $userid, $up);
    }

    public function saveQuestionRating($up, $questionid, $userid)
    {
        $urq = new UserRatesQuestion();
        $urq->questionid = $questionid;
        $this->ratingSave($urq, $userid, $up);
    }

    public function ratingSave($object, $userid, $up)
    {
        $object->up = $up;
        $object->userid = $userid;
        $object->created = $this->centralEuropeanTime();
        $object->setDb($this->di->get("dbqb"));
        $object->save();
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
        $answer->userid = $userid;
        $answer->questionid = $questionid;
        $answer->textbody = htmlentities($textbody);
        $answer->accepted = 0;
        $this->saveDefault($answer);
    }

    public function saveAComment($answerid, $userid, $textbody)
    {
        $acomment = new AComment();
        $acomment->userid = $userid;
        $acomment->answerid = $answerid;
        $acomment->textbody = htmlentities($textbody);
        $this->saveDefault($acomment);
    }

    public function saveQComment($questionid, $userid, $textbody)
    {
        $qcomment = new QComment();
        $qcomment->userid = $userid;
        $qcomment->questionid = $questionid;
        $qcomment->textbody = htmlentities($textbody);
        $this->saveDefault($qcomment);
    }

    public function saveQuestion($title, $textbody, $userid, $tags)
    {
        $question = new Question();
        $question->title = $title;
        $question->textbody = htmlentities($textbody);
        $question->userid = $userid;
        $this->saveDefault($question);
        $this->saveQuest2Tag($tags, $textbody); // $tags is an array of tagids
    }

    public function saveQuest2Tag($tags, $textbody)
    {
        $getstuff = new Getstuff($this->di);
        $questions = $getstuff->getQuestionsWhere("textbody = ?", htmlentities($textbody));
        $id = 1;
        $questionlength = count($questions);
        for ($i=0; $i < $questionlength; $i++) {
            $id = $questions[$i]->id;
        }
        $taglength = count($tags);
        for ($i=0; $i < $taglength; $i++) {
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
        $user->email = $email;
        $user->password = md5($password);
        $user->name = $name;
        $user->gravatar = "https://www.gravatar.com/avatar/" . md5($email). "?s=32&d=identicon&r=PG";
        $this->saveDefault($user);
    }

    public function saveDefault($object)
    {
        $object->rating = 0;
        $object->created = $this->centralEuropeanTime();
        $object->updated = null;
        $object->deleted = null;
        $object->setDb($this->di->get("dbqb"));
        $object->save();
    }
}
