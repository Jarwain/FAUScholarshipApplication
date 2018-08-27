<?php
namespace ScholarshipApi\Model\Question;

use Respect\Validation\Validator as v;

class FileQuestion extends Question{
    function __construct($id, $question, $props = []){
        $this->type = parent::TYPE_FILE;
        $this->setRequiredProps(['filetype']);

        parent::__construct($id, $question, $props);
    }

    function getFiletypes(){
        return $this->getProp('filetype');
    }
}
