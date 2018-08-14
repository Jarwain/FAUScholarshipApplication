<?php
namespace ScholarshipApi\Model\Question;

use Respect\Validation\Validator as v;

class VideoQuestion extends Question{

    function __construct($id, $question, $props = []){
        $this->type = parent::TYPE_VIDEO;
        $this->setOptionalProps(['minLength', 'maxLength']);

        parent::__construct($id, $question, $props);
    }
}
