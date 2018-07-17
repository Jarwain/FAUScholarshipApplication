<?php
namespace ScholarshipApi\Model\Scholarship;

// TODO: Rename OnlineScholarship to "ApplicableScholarship" or something that better captures its function
class ApplicableScholarship extends Scholarship{
    var $max;

    var $requirements;
    var $questions; // TODO

    function __construct($code, $name, $description, $active, $max = 0){
        parent::__construct($code, $name, $description, $active);

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
        $this->requirements[$r->category][$r->qualifier->id] = $r;
    }

    function addRequirements(array $requirements){
        $this->requirements = $requirements;
    }

    function addQuestions(array $questions){
        $this->questions = $questions;   
    }
}