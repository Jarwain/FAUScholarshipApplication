<?php
namespace ScholarshipApi\Model\Question;

class QuestionRepository implements QuestionStore{
    private $questions = Null;
    private $scholarshipMap = Null;

    private $database;

    function __construct(QuestionStore $database){
        $this->database = $database;
    }

    function getAll(){
        $this->questions = $this->questions ?? 
            $this->database->getAll();
        return $this->questions;
    }

    function get($id){
        $q = $this->questions[$id] ??
            $this->database->get($id);
        return $q;
    }
}
