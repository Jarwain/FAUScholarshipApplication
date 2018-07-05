<?php
namespace ScholarshipApi\Model\Qualifier;

abstract class Qualifier {
    var $id;
    var $name;
    var $question;

    var $type;
    var $options;

    function __construct($id, $name, $type, $question, $options = []){
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->question = $question;
        $this->options = $options;
    }

    abstract function validate($term, $valid = Null);

    abstract static function DataMap(array $data);

    function getId(){
        return $this->id;
    }
    function getName(){
        return $this->name;
    }
    function getType(){
        return $this->type;
    }
    function getQuestion(){
        return $this->question;
    }
    function getOptions(){
        return $this->options;
    }
}