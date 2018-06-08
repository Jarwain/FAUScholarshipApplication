<?php
namespace ScholarshipApi\Model\Question;

use Respect\Validation\Validator as v;

class EssayQuestion extends Question{
    var $min_words;
    var $max_words;

    function __construct($id, $type, $question, $min_word, $max_word, $options = []){
        parent::__construct($id, $type, $question, $options);

        $this->min_words = $min_word;
        $this->max_words = $max_word;
    }

    static function DataMap(array $data){
        $opt = $data['options'];
        $options = [];
        return new EssayQuestion($data['id'], $data['type'], $data['question'], $opt['word_count'][0], $opt['word_count'][1], $options);
    }

}