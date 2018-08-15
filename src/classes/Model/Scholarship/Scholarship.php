<?php
namespace ScholarshipApi\Model\Scholarship;

abstract class Scholarship{
    var $id;
    var $code;
    var $name;
    var $description;
    var $active;

    function __construct($id = NULL, $code, $name, $description, $active){
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->active = (bool) $active;
    }

    abstract static function DataMap($data);

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
