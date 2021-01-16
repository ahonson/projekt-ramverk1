<?php

namespace artes\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Question extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Question";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $userid;
    public $title;
    public $textbody;
    public $rating;
    public $created;



    public function findAllWhereJoinOrder($order, $table, $join, $value, $limit = 100, $select = "*")
    {
        $this->checkDb();
        $params = is_array($value) ? $value : [$value];
        return $this->db->connect()
            ->select($select)
            ->from($this->tableName)
            ->orderBy($order)
            ->where("category = ?")
            ->join($table, $join)
            ->limit($limit)
            ->execute($params)
            ->fetchAllClass(get_class($this));
    }

    // public function findAllWhereJoinOrder($order, $table, $join, $value, $limit = 100, $select = "*")
    // {
    //     $this->checkDb();
    //     $params = is_array($value) ? $value : [$value];
    //     return $this->db->connect()
    //         ->select($select)
    //         ->from($this->tableName)
    //         ->orderBy($order)
    //         ->where("category = ?")
    //         ->join($table, $join)
    //         ->limit($limit)
    //         ->execute($params)
    //         ->fetchAllClass(get_class($this));
    // }
}
