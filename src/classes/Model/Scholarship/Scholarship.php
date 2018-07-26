<?php
namespace ScholarshipApi\Model\Scholarship;

abstract class Scholarship{
    var $code;
    var $name;
    var $description;
    var $active;

    function __construct($code, $name, $description, $active){
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->active = (bool) $active;
    }

    function getCode(){
        return $this->code;
    }

    function getName(){
        return $this->name;
    }

    function getDescription(){
        return $this->description;
    }

    function getActive(){
        return $this->active;
    }
}
