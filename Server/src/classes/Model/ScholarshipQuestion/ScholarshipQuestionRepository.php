<?php
namespace ScholarshipApi\Model\ScholarshipQuestion;

class ScholarshipQuestionRepository implements ScholarshipQuestionStore{
    private $questionMap = Null;

    private $database;

    function __construct(ScholarshipQuestionStore $database){
        $this->database = $database;
    }

    function getAll(){
        $this->questionMap = $this->questionMap ??
            $this->database->getAll();
        return $this->questionMap;
    }

    function get($code){
        return $this->questionMap[$code] ??
            $this->database->get($code);
    }

    function create($code, $question){
        return $this->database->create($code, $question);
    }
}
