<?php
namespace ScholarshipApi\Model\Scholarship;

use ScholarshipApi\Model\Requirement\RequirementStore;
use ScholarshipApi\Model\ScholarshipQuestion\ScholarshipQuestionStore;

class ScholarshipFactory{
    private $requirements;
    private $questions;

    function __construct(RequirementStore $requirements, ScholarshipQuestionStore $questions){
        $this->requirements = $requirements;
        $this->questions = $questions;
    }

    function bulkInitialize($data){
        $scholarships = [];

        $this->requirements->getAll(); // Cache Requirements & Questions
        $this->questions->getAll(); // This will minimize load on the DB

        foreach($data as $sch){
            $code = $sch['code'];
            $scholarships[$code] = $this->initialize($sch);
        }
        
        return $scholarships;
    }

    function initialize($data){
        $sch = new ApplicableScholarship(
            $data['code'], $data['name'], $data['description'], $data['active'], 
            $data['max']);
        $sch->setRequirements($this->requirements->get($sch->getCode()));
        $sch->setQuestions($this->questions->get($sch->getCode()));
        // TODO: Set URL & Deadline based on application details
        return $sch;
    }
}
