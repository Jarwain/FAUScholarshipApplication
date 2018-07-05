<?php
namespace ScholarshipApi\Model\Question;

use Respect\Validation\Validator as v;

class FileQuestion extends Question{
    var $filetype;

    function __construct($id, $type, $question, $filetype, $options = []){
        parent::__construct($id, $type, $question, $options);

        $this->filetype = $filetype;
    }

    static function DataMap(array $data){
        $opt = $data['options'];
        $options = [];
        return new FileQuestion($data['id'], $data['type'], $data['question'], $opt['filetype'], $options);
    }

}