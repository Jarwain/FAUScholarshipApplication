<?php
namespace ScholarshipApi\Model\Requirement;

class Requirement{
    var $id;
    var $category;
    var $qualifier;
    var $valid;

    // TODO: (maybe)Refactor so that there's $pass and $fail

    function __construct($id = NULL, $category, $qualifier, $valid){
        $this->id = $id;
        $this->category = $category;
        $this->qualifier = $qualifier;
        $this->valid = $valid;
    }

    static function DataMap(array $data){
        return new Requirement($data['id'] ?? NULL, $data['category'], 
            $data['qualifier'], $data['valid']);
    }

    function validate($term){
        return $this->qualifier->validate($term, $this->valid);
    }

    function getId(){
        return $this->id;
    }

    function getScholarshipCode(){
        return $this->scholarship_code;
    }

    function getCategory(){
        return $this->category;
    }

    function getQualifier(){
        return $this->qualifier;
    }

    function getQualifierId(){
        return $this->qualifier->getId();
    }
}