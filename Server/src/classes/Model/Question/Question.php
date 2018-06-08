<?php
namespace ScholarshipApi\Model\Question;

abstract class Question {
    var $id;
    var $question;

    var $type;
    var $options;

    function __construct($id, $type, $question, $options = []){
        $this->id = $id;
        $this->type = $type;
        $this->question = $question;
        $this->options = $options;
    }

    abstract static function DataMap(array $data);

    function getId(){
        return $this->id;
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