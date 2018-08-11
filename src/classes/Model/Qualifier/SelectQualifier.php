<?php
namespace ScholarshipApi\Model\Qualifier;

use Respect\Validation\Validator as v;

class SelectQualifier extends Qualifier{

    function __construct($id, $name, $question, $props = []){
        $this->type = parent::TYPE_SELECT; 
        $this->setRequiredProps(['haystack']);
        $this->setOptionalProps(['multi', 'other']);

        parent::__construct($id, $name, $question, $props);
    }

    function getHaystack(){
        return $this->getProp('haystack');
    }

    function isMulti(){
        return $this->getProp('multi') ?? False;
    }

    function otherable(){
        return $this->getProp('multi') ?? False;
    }

    /**
     * Check if term is in $haystack. 
     * Returns True on success, returns reason on failure
     * if validating requirement, checks if term is in $valid
     */
    function validate($term, $valid = Null){
        $haystack = $valid ?? $this->getHaystack();
        $validator = v::in($haystack);

        // If they can input a custom value
        // AND it's not validating a Requirement
        if($this->otherable() && is_null($valid))
            return True;

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

/*    function renderInput(){
        $multi = $this->isMulti() ? 'multiple' : '';
        $open = <<<OPEN
        <div class='form-group'>
          <label class='col-sm-3 col-form-label' for='{$this->getName()}'>{$this->getQuestion()}</label>
          <select {$multi} class='form-control' id='{$this->getName()}'>
OPEN;
        $mid = "";
        foreach($this->getHaystack() as $option){
            $mid .="<option value='{$option}'>{$option}</option>";
        }
        $close = "
          </select>
        </div>";
        return $open.$mid.$close;
    }*/
}
