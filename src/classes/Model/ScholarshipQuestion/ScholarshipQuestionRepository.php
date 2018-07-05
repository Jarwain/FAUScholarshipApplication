<?php
namespace ScholarshipApi\Model\ScholarshipQuestion;

use ScholarshipApi\Model\AbstractRepository;

class ScholarshipQuestionRepository extends AbstractRepository implements ScholarshipQuestionStore{
    function bind($code, $data){
        foreach($data as $questionId){
            $question = [
                "code" => $code,
                "question" => $questionId
            ];
            $this->create($question);
        }
    }
}
