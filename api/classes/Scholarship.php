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
    return new Scholarship($arr->id, $arr->active, $arr->category, $arr->name, $arr->description, $arr->url, $arr->deadline);
  }
}

/*class ApplicationScholarship extends Scholarship{
  var $requirements;
  var $questions;
}*/