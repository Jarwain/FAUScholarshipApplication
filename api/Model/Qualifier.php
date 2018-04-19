<?php
namespace FAUScholarship\API\Model;

class Qualifier {
    var $qualifier;
    var $name;
    var $form;
    var $question;
    var $param;
    var $regex;

    function __construct($qualifier, $name, $form, $question, $param = NULL, $regex = NULL){
        $this->qualifier = $qualifier;
        $this->name = $name;
        $this->form = $form;
        $this->question = $question;
        $this->param = $param;
        $this->regex = $regex;
    }
}
