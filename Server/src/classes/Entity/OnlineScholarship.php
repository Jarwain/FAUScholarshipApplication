<?php
namespace ScholarshipApi\Entity;

class OnlineScholarship extends AbstractScholarship{
    var $counter; // TODO: Change to count applications
    var $max;

    var $requirements;
    var $questions; // TODO

    function __construct($code, $name, $description, $active, $counter = 0, $max = 0, array $requirements = NULL, array $questions = NULL){
        parent::__construct($code, $name, $description, $active, 1);

        $this->counter = (int) $counter;
        $this->max = (int) $max;
        $this->requirements = $requirements;
        $this->questions = $questions;
    }

    static function Factory(array $data){
        return new OnlineScholarship($data['code'], $data['name'], $data['description'], $data['active'], $data['counter'], $data['max'], $data['requirements'] ?? NULL, $data['questions'] ?? NULL);
    }

    function addRequirement(Requirement $r){
        $this->requirements[$r->category][$r->qualifier->id] = $r;
    }

    function addRequirements(array $requirements){
        foreach($requirements as $cat=>$reqs){
            $this->requirements[$cat] = $reqs;
        }
    }
}