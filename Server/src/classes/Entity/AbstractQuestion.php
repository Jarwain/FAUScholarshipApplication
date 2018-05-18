<?php
namespace ScholarshipApi\Entity;

abstract class Question{
    var $id;
    var $question;
    var $type;

    function __construct($id = NULL, $question){
        $this->id = $id;
        $this->question = $question;
    }

    abstract static function Factory(array $data);
}