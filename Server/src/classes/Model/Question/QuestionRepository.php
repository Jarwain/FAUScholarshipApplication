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

    function getAllByScholarship(){
        if(is_null($this->scholarshipMap)){
            $this->getAll();
            $map = $this->database->getAllByScholarship();
            $result = [];
            foreach($map as $q){
                $result[$q['code']][$q['question']] = $this->get($q['question']);
            }

            $this->scholarshipMap = $result;
        }
            

        return $this->scholarshipMap;
    }

    function getByScholarship($code){
        if(is_null($this->scholarshipMap[$code])){
            $map = $this->database->getByScholarship($code);
            $result = [];
            foreach($map as $q){
                $result[$q['code']][$q['question']] = $this->get($q['question']);
            }
            return $result;
        }
        return $this->scholarshipMap[$code];
    }
}