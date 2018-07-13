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
        return new MultiQualifier($data['id'], $data['name'], $data['type'], $data['question'], $param, $options);
    }

    function renderInput(){
        $out = "
        <div class='form-group'>
            <label class='col-sm-3 col-form-label' for='{$this->getName()}'>{$this->getQuestion()}</label>
            <select multiple class='form-control' id='{$this->getName()}'>";
        foreach($this->haystack as $option){
            $out .= "<option value='{$option}'>{$option}</option>";
        }
        $out .=    "</select>
        </div>
        ";
        echo $out;
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