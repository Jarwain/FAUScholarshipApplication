<?php
class Scholarship {
    var $id;
    var $category;
    var $name;
    var $description;
    var $active;

    var $url;
    var $deadline;

    function __construct($id, $active, $category, $name, $description, $url = null, $deadline = null){
        $this->id = $id;
        $this->category = $category;
        $this->name = $name;
        $this->description = $description;
        $this->active = $active;

        $this->url = $url;
        $this->deadline = $deadline;
    }

    static function FactoryArray($arr){
        return new Scholarship($arr['id'], $arr['active'], $arr['category'], $arr['name'], $arr['description'], $arr['url'], $arr['deadline']);
    }
}

class ApplicationScholarship extends Scholarship{
    var $counter;
    var $limit;
    var $requirements;
    // var $questions;

    function __construct($id, $active, $category, $name, $description, $counter, $limit, $requirements = array()){
        parent::__construct($id, $active, $category, $name, $description);

        $this->counter = $counter;
        $this->limit = $limit;
        $this->requirements = $requirements;
    }

    static function FactoryArray($arr){
        return new ApplicationScholarship($arr['id'], $arr['active'], $arr['category'], $arr['name'], $arr['description'], $arr['counter'], $arr['limit'], $arr['requirements']);
    }
}