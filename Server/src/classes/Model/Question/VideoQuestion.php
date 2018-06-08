<?php
namespace ScholarshipApi\Model\Question;

use Respect\Validation\Validator as v;

class VideoQuestion extends Question{

    function __construct($id, $type, $question, $options = []){
        parent::__construct($id, $type, $question, $options);

    }

    static function DataMap(array $data){
        $opt = $data['options'];
        $options = [];
        return new FileQuestion($data['id'], $data['type'], $data['question'], $options);
    }

}