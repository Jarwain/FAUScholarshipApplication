<?php
namespace ScholarshipApi\Model\Requirement;

class Requirement{
    var $id;
    var $category;
    var $qualifier;
    var $valid;

    // TODO: (maybe)Refactor so that there's $pass and $fail

    function __construct($id, $category, $qualifier, $valid){
        $this->id = $id;
        $this->category = $category;
        $this->qualifier = $qualifier;
        $this->valid = $valid;
    }

    function validate($term){
        return $this->qualifier->validate($term, $this->valid);
    }

    function getId(){
        return $this->id;
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

    function getValid(){
        return $this->valid;
    }
}
