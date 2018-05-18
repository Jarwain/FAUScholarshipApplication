<?php
namespace ScholarshipApi\Repository;

use ScholarshipApi\Repository\DataAccessObject\QuestionDatabase;
use ScholarshipApi\Entity\Question;

class QuestionRepository{
    var $database;
    var $cache; // TODO: (low priority)

    function __construct(\PDO $db){
        $this->database = new QuestionDatabase($db);
    }

    function getAll(){
        $data = $this->database->getAll();
        $qualifiers = [];

        foreach($data as $q){
            $qualifiers[$q['id']] = Question::Factory($q);
        }

        return $qualifiers;
    }

    function get($id){
        return Question::Factory($this->database->get($id));
    }
}