<?php
namespace ScholarshipApi\Model\Question;

abstract class Question {
    use \ScholarshipApi\Model\PropTrait;
    public $id;
    public $question;

    public $type;
    const TYPE_ESSAY = 'essay';
    const TYPE_FILE = 'file';
    const TYPE_VIDEO = 'video';

    private $requiredProps = [];
    private $optionalProps = ['required'];

    function __construct($id, $question, $props = []){
        $this->id = $id;
        $this->question = $question;
        $this->setProps($props);

        $this->checkRequiredProps();
    }

    function isRequired(){
        $required = $this->getProp('required');
        if(is_null($required))
            return False;
        else
            return $required;
    }

    function getId(){
        return $this->id;
    }

    function getType(){
        return $this->type;
    }

    function getQuestion(){
        return $this->question;
    }
}