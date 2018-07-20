<?php
namespace ScholarshipApi\Model\Question;

abstract class Question {
    use \ScholarshipApi\Model\OptionTrait;
    public $id;
    public $question;

    public $type;
    const TYPE_ESSAY = 'essay';
    const TYPE_FILE = 'file';
    const TYPE_VIDEO = 'video';

    function __construct($id, $question, $options = []){
        $this->id = $id;
        $this->question = $question;
        $this->options = $options;

        $this->checkRequiredOptions();
    }

    function isRequired(){
        if(is_null($this->getOption('required')))
            return false;
        else
            return true;
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