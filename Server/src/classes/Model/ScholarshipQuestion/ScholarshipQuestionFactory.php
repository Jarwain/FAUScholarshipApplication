<?php
namespace ScholarshipApi\Model\ScholarshipQuestion;

use ScholarshipApi\Model\Question\QuestionStore;

class ScholarshipQuestionFactory{
    private $questions;
    
    function __construct(QuestionStore $questions){
        $this->question = $questions;
    }

    function initialize($data){
        $scholarships = [];
        foreach($data as $q){
            $scholarships[$q['code']][$q['question']] = $this->questions->get($q['question']);
        }
        return $scholarships;
    }
}
