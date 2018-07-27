<?php
namespace ScholarshipApi\Model\Question;

use Respect\Validation\Validator as v;

class EssayQuestion extends Question{

    function __construct($id, $question, $props = []){
        $this->type = parent::TYPE_ESSAY;
        $this->setOptionalProps(['min_words', 'max_words']);

        parent::__construct($id, $question, $props);
    }

    function getMinWords(){
        return $this->getProp('min_words');
    }

    function getMaxWords(){
        return $this->getProp('max_words');
    }
}