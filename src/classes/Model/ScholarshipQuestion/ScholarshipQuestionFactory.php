<?php
namespace ScholarshipApi\Model\ScholarshipQuestion;

use ScholarshipApi\Model\Question\QuestionStore;

class ScholarshipQuestionFactory{
    private $questions;
    
    function __construct(QuestionStore $questions){
        $this->questions = $questions;
    }

    function initialize($data){
        $scholarships = [];
        foreach($data as $q){
            $scholarships[$q['code']][] = $this->questions->get($q['question']);
        }
        return $scholarships;
    }
}
