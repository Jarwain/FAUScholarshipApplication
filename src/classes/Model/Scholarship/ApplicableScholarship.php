<?php
namespace ScholarshipApi\Model\Scholarship;

class ApplicableScholarship extends Scholarship{
    var $max;

    var $requirements;
    var $questions; 

    function __construct($id = NULL, $code, $name, $description, $active, $max = 0){
        parent::__construct($id, $code, $name, $description, $active);

        $max = $max ?? 0;
        $this->setMax($max);
    }

    function setMax(int $max = 0){
        $this->max = $max;
    }

    function getMax(){
        return $this->max;
    }

    function addRequirement(Requirement $r){
        $this->requirements[$r->getCategory()][] = $r;
    }

    function setRequirements(array $requirements){
        $this->requirements = $requirements;
    }
    function getRequirements(){
        return $this->requirements;
    }

    function setQuestions(array $questions){
        $this->questions = $questions;   
    }
    function getQuestions(){
        return $this->questions;
    }
}
