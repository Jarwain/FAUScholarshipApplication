<?php
namespace FAUScholarship\API\Model;

class Requirement extends Qualifier{
    var $category;
    var $valid;

    function __construct($qualifier, $name, $form, $question, $param, $regex, $category, $valid = NULL){
        parent::__construct($qualifier, $name, $form, $question, $param, $regex);

        $this->category = $category;
        $this->valid = $valid;
    }
}