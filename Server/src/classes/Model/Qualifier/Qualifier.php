<?php
namespace ScholarshipApi\Model\Qualifier;

abstract class Qualifier {
    var $id;
    var $name;
    var $question;

    var $type;

    function __construct($id, $name, $form, $question){
        $this->id = $id;
        $this->name = $name;
        $this->form = $form;
        $this->question = $question;
    }

    abstract function validate($term, $valid = Null);

    abstract static function DataMap(array $data);
}