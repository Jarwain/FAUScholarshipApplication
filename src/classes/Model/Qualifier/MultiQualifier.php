<?php
namespace ScholarshipApi\Model\Qualifier;

use Respect\Validation\Validator as v;

class MultiQualifier extends Qualifier{
    var $haystack;

    function __construct($id, $name, $type, $question, $haystack, $options = []){
        parent::__construct($id, $name, $type, $question, $options);
        $this->haystack = $haystack;
    }

    static function DataMap(array $data){
        $opt = $data['options'];
        $param = $opt['param'];
        $options = [];
        return new SingleQualifier($data['id'], $data['name'], $data['type'], $data['question'], $param, $options);
    }

    /**
     * Check if term is in $haystack. 
     * Returns True on success, returns reason on failure
     */
    function validate($term, $valid = Null){
        $haystack = $valid ?? $this->haystack;
        $validator = v::in($haystack);

        foreach($term as $t){
            if($validator->validate($t)){
                return True;
            }
        }
        return json_encode($term)." not in ".json_encode($haystack);
    }

}