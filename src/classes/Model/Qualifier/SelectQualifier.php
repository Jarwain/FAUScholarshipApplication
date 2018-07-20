<?php
namespace ScholarshipApi\Model\Qualifier;

use Respect\Validation\Validator as v;

class SelectQualifier extends Qualifier{

    function __construct($id, $name, $question, $options = []){
        $this->type = parent::TYPE_SELECT; 
        $this->requiredOptions = ['haystack'];

        parent::__construct($id, $name, $question, $options);
    }

    function getHaystack(){
        return $this->getOption('haystack');
    }

    function isMulti(){
        return $this->getOption('multi') ?? False;
    }

    function renderInput(){
        $out = "
        <div class='form-group'>
            <label class='col-sm-3 col-form-label' for='{$this->getName()}'>{$this->getQuestion()}</label>
            <select ";

        if($this->isMulti()){
            $out .= 'multiple ';
        }

        $out .= "class='form-control' id='{$this->getName()}'>";

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
        $haystack = $valid ?? $this->getHaystack();
        $validator = v::in($haystack);

        if($this->isMulti()){
            foreach($term as $t){
                if($validator->validate($t)){
                    return True;
                }
            }
            return json_encode($term)." not in ".json_encode($haystack);
        } else {
            try{
                $validator->assert($term);
            } catch(NestedValidationException $e) {
                return $e->getMessages();
            } catch(UnexpectedValueException $e) {
                return $e->getMessage();
            }

            return True;
        }
    }

}