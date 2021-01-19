<?php

namespace artes\Updatestuff;

use artes\Getstuff\Getstuff;

/**
  * A class for adding stuff to the db.
  *
  * @SuppressWarnings(PHPMD)
  */
class Updatestuff
{
    private $di;
    private $getstuff;

    public function __construct($di)
    {
        $this->di = $di;
        $this->getstuff = new Getstuff($this->di);
    }

    // public function editAnswerRating()
    // {
    //
    // }
    //
    // public function editACommentRating()
    // {
    //
    // }
    //
    // public function editQCommentRating()
    // {
    //
    // }
    //
    // public function editQuestionRating()
    // {
    //
    // }

    public function editUser($id, $password)
    {
        $user = $this->getstuff->getUser($id);
        $user->setDb($this->di->get("dbqb"));
        $user->password = md5($password);
        $user->save();
    }

    public function editQuestion($value, $id)
    {
        $question = $this->getstuff->getQuestion($id);
        unset($question->tags);
        $this->saveValue($question, $value);
    }

    public function editAnswer($value, $id)
    {
        $answer = $this->getstuff->getAnswer($id);
        $this->saveValue($answer, $value);
    }

    public function editAComment($value, $id)
    {
        $acomment = $this->getstuff->getComment($id, "a");
        $this->saveValue($acomment, $value);
    }

    public function editQComment($value, $id)
    {
        $qcomment = $this->getstuff->getComment($id);
        $this->saveValue($qcomment, $value);
    }

    public function saveValue($object, $value)
    {
        $object->setDb($this->di->get("dbqb"));
        $object->rating += $value;
        $object->save();
    }
}
