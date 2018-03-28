<?php
class Qualifier {
    var $id;
    var $name;
    var $question;
    var $param;

    function __construct($id, $name, $question, $param){
        $this->id = $id;
        $this->name = $name;
        $this->question = $question;
        $this->param = $param;
    }
}

class Requirement extends Qualifier{
    var $group;
    var $valid;

    function __construct($id, $name, $question, $param, $group, $valid){
        parent::__construct($id, $name, $question, $param);

        $this->group = $group;
        $this->valid = $valid;
    }
}
