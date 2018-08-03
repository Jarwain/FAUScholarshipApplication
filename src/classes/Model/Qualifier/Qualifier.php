<?php
namespace ScholarshipApi\Model\Qualifier;

abstract class Qualifier {
    use \ScholarshipApi\Model\PropTrait;
    public $id;
    public $name;
    public $question;

    public $type;
    const TYPE_BOOL = 'bool';
    const TYPE_RANGE = 'range';
    const TYPE_SELECT = 'select';

    private $requiredProps = [];
    private $optionalProps = [];

    function __construct($id, $name, $question, $props = []){
        $this->id = $id;
        $this->name = $name;
        $this->question = $question;
        $this->setProps($props);

        $this->checkRequiredProps();
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