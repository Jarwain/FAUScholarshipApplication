<?php
namespace FAUScholarship\API\Model;

use FAUScholarship\API\Model\Requirement;

class OnlineScholarship extends AbstractScholarship{
    var $counter; // TODO: Change to count applications
    var $max;

    var $requirements;
    // var $questions;

    function __construct($code, $name, $description, $active, $counter, $max, array $requirements = array()){
        parent::__construct($code, $name, $description, $active);

        $this->counter = $counter;
        $this->max = $max;
        $this->requirements = $requirements;

        $this->category = 1;
    }

    public function addRequirement(Requirement $r = NULL){
        if(isset($r)){
            $this->requirements[$r->category][$r->qualifier] = $r;
        }
    }
}