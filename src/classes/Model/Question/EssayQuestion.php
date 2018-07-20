<?php
namespace ScholarshipApi\Model\Question;

use Respect\Validation\Validator as v;

class EssayQuestion extends Question{

    function __construct($id, $question, $options = []){
        $this->type = parent::TYPE_ESSAY;
        $this->requiredOptions = ['word_count'];

        parent::__construct($id, $question, $options);
    }

    function getMinWords(){
        return $this->getOption('word_count')[0];
    }

    function getMaxWords(){
        return $this->getOption('word_count')[1];
    }
}