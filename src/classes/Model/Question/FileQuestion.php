<?php
namespace ScholarshipApi\Model\Question;

use Respect\Validation\Validator as v;

class FileQuestion extends Question{
    var $filetype;

    function __construct($id, $question, $options = []){
        $this->type = parent::TYPE_FILE;
        $this->requiredOptions = ['filetype'];

        parent::__construct($id, $question, $options);
    }

    function getFiletypes(){
        return $this->getOption('filetype');
    }
}