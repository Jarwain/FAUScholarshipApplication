<?php
namespace ScholarshipApi\Model\Scholarship;

class ApplicableScholarship extends Scholarship implements \JsonSerializable{
    var $max;
    var $app_count; // NOTE: app_count represents total accepted + undecided. Rejects aren't counted

    var $requirements;
    var $questions;
    var $open;
    var $close;

    var $studentApplied = false;
    var $studentQualifies = null;

    function __construct($id = NULL, $code, $name, $description, $active,
        $open = False, $close = False, $max = 0, $app_count = 0){
        parent::__construct($id, $code, $name, $description, $active);

        $this->max = $max;
        $this->app_count = $app_count;
        $this->open = strtotime($open); // Is false if not set
        $this->close = strtotime($close);
    }

    static function DataMap($data){
        return new ApplicableScholarship($data['id'], $data['code'], $data['name'], $data['description'], 
            $data['active'], $data['open'], $data['close'], $data['max'], $data['app_count']);
    }

    function jsonSerialize(){
        $result = [
            "id" => (int) $this->id,
            "code" => $this->code,
            "name" => $this->name,
            "description" => $this->description,
            "active" => $this->active,
            "open" => date("F j, Y h:i A", $this->open),
            "close" => date("F j, Y h:i A", $this->close),
            "max" => (int) $this->max,
            "app_count" => (int) $this->app_count,
            "questions" => $this->getQuestions(),
            "requirements" => $this->getRequirements(),
            "requirement_categories" => $this->getRequirementCategories(),
            "not_applicable" => $this->notApplicable(),
        ];

        if(!is_null($this->studentQualifies)){
            $result['qualifies'] = $this->studentQualifies;
        }
        return $result;
    }

    /* 
    Scholarship is applicable if it is active 
        AND
    ---    
    if the max is 0 (there is no max allowed number of applications that may be submitted)
        OR 
    if the number of applications submitted is less than the max allowed
    ---
        AND
    ---
    if open is unset or today > open
    AND
    close is unset or today < clo
    */
    function notApplicable(){
        $result = false;

        $today = time();
        if($this->open && $today < $this->open){
            $result[] = "Scholarship Applications open on "
                            .date("F j, Y h:i A", $this->open);
        }
        if($this->close && $today > $this->close){
            $result[] = "Scholarship Applications closed on "
                            .date("F j, Y h:i A", $this->close);
        }

        if($this->max !== 0 && $this->app_count >= $this->max){
            $result[] = "Total number of applications has been reached";
        }

        if($this->studentApplied){
            $result[] = "You have already applied for this scholarship";
        }

        if(!$this->active){
            $result[] = "Scholarship is inactive";
        }

        return $result;
    }

    function setStudentApplied(){
        $this->studentApplied = true;
    }

    function setStudentQualifies(bool $q){
        $this->studentQualifies = $q;
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

    function getRequirements($category = Null){
        if(is_null($category)){
            return $this->requirements;
        } else{
            return array_filter($this->requirements, function($e) use ($category){
                return $e->getCategory() == $category;
            });
        }
    }

    function getRequirementCategories(){
        return array_reduce($this->getRequirements(), function($a,$e){
          $cat = $e->getCategory();
          if(!in_array($cat, $a)){
            $a[] = $cat;
          }
          return $a;
        }, []);
    }

    function setQuestions(array $questions){
        $this->questions = $questions;   
    }
    function getQuestions(){
        return $this->questions;
    }
}
