<?php
namespace ScholarshipApi\Model\Scholarship;

abstract class Scholarship{
    var $code;
    var $name;
    var $description;
    var $active;

    var $url;
    var $deadline;

    const ONLINE = 1;
    const INTERNAL = 2;
    const EXTERNAL = 3;
    var $category = Null;

    function __construct($code, $name, $description, $active){
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->active = (bool) $active;
    }

    abstract static function Factory($data);

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

    function setUrl($url){
        $this->url = $url;
    }
    function getUrl(){
        return $this->url;
    }

    function setDeadline($deadline){
        $this->deadline = $deadline;
    }
    function getDeadline(){
        return $this->deadline;
    }

    function getCategory(){
        return $this->category;
    }
}