<?php
namespace ScholarshipApi\Entity;

class EssayQuestion extends Question{
    var $wordMinimum;
    var $wordMaximum;
    
    function __construct($id = NULL, $question, $min, $max){
        parent::__construct($id, $question, 'essay');
        $this->wordMinimum = $min;
        $this->wordMaximum = $max;
    }
}