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

    public function __construct($di)
    {
        $this->di = $di;
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
    //
    // public function editUser()
    // {
    //
    // }

    public function editQuestion($value, $id)
    {
        $getstuff = new Getstuff($this->di);
        $question = $getstuff->getQuestion($id);
        $question->setDb($this->di->get("dbqb"));
        $question->rating += $value;
        $question->save();
    }

    public function editAnswer($value, $id)
    {
        $getstuff = new Getstuff($this->di);
        $answer = $getstuff->getAnswer($id);
        $answer->setDb($this->di->get("dbqb"));
        $answer->rating += $value;
        $answer->save();
    }

    public function editAComment($value, $id)
    {
        $getstuff = new Getstuff($this->di);
        $acomment = $getstuff->getComment($id, "a");
        $acomment->setDb($this->di->get("dbqb"));
        $acomment->rating += $value;
        $acomment->save();
    }

    public function editQComment($value, $id)
    {
        $getstuff = new Getstuff($this->di);
        $qcomment = $getstuff->getComment($id);
        $qcomment->setDb($this->di->get("dbqb"));
        $qcomment->rating += $value;
        $qcomment->save();
    }
}
