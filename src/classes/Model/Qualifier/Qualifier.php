<?php
namespace ScholarshipApi\Model\Qualifier;


abstract class Qualifier {
    use \ScholarshipApi\Model\OptionTrait;
    public $id;
    public $name;
    public $question;

    public $type;
    const TYPE_BOOL = 'bool';
    const TYPE_RANGE = 'range';
    const TYPE_SELECT = 'select';

    function __construct($id, $name, $question, $options = []){
        $this->id = $id;
        $this->name = $name;
        $this->question = $question;
        $this->options = $options;

        $this->checkRequiredOptions();
    }

    abstract function renderInput();

    abstract function validate($term, $valid = Null);

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
}