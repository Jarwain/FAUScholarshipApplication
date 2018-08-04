<?php
namespace ScholarshipApi\Model\Scholarship;

class ApplicableScholarship extends Scholarship{
    var $max;
    var $total; // NOTE: Total represents total accepted + undecided. Rejects aren't counted

    var $requirements;
    var $questions; 

    function __construct($id = NULL, $code, $name, $description, $active, $max = 0, $total = 0){
        parent::__construct($id, $code, $name, $description, $active);

        $this->max = $max;
        $this->total = $total;
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
