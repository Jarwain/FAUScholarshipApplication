<?php
namespace ScholarshipApi\Model\Question;

use Respect\Validation\Validator as v;

class VideoQuestion extends Question{

    function __construct($id, $question, $options = []){
        $this->type = parent::TYPE_VIDEO;
        $this->requiredOptions = [];

        parent::__construct($id, $question, $options);
    }
}