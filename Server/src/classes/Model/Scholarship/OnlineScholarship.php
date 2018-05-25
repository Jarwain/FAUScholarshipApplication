<?php
namespace ScholarshipApi\Model\Scholarship;

// TODO: Rename OnlineScholarship to "ApplicableScholarship" or something that better captures its function
class OnlineScholarship extends Scholarship{
    var $max;

    var $requirements;
    var $questions; // TODO

    function __construct($code, $name, $description, $active, $max = 0){
        parent::__construct($code, $name, $description, $active);

        $max = $max ?? 0;
        $this->setMax($max);
        $this->category = self::ONLINE;
    }

    static function DataMap($data){
        return new OnlineScholarship(
            $data['code'], $data['name'], $data['description'], $data['active'], $data['max']);
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
        foreach($requirements as $cat=>$reqs){
            $this->requirements[$cat] = $reqs;
        }
    }
}