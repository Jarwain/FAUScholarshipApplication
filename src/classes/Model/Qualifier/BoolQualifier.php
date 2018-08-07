<?php
namespace ScholarshipApi\Model\Qualifier;

use Respect\Validation\Validator as v;

class BoolQualifier extends Qualifier{

    function __construct($id, $name, $question, $props = []){
        $this->type = parent::TYPE_BOOL;
        
        parent::__construct($id, $name, $question, $props);
    }

    /**
     * Check if term is boolean. If valid is set, check if term is True.
     * Returns True on success, returns reason on failure
     */
    function validate($term, $valid = Null){
        $validator = v::boolVal();
        if($valid){
            $validator = $validator->v::trueVal();
        }

        try{
            $validator->assert($term);
        } catch(NestedValidationException $e) {
            return $e->getMessages();
        } catch(UnexpectedValueException $e) {
            return $e->getMessage();
        }

        return True;
    }

/*    function renderInput(){
        return <<<EOT
        <div class='form-group row'>
          <label class='col-sm-3 col-form-label' for='{$this->getName()}'>{$this->getQuestion()}</label>
          <div class='col-sm-9'>
              <div class='form-check form-check-inline'>
                  <input class='form-check-input' type='radio' name='{$this->getName()}' id='{$this->getName()}true' value='true'>
                  <label class='form-check-label' for='{$this->getName()}true'>Yes</label>
              </div>
              <div class='form-check form-check-inline'>
                  <input class='form-check-input' type='radio' name='{$this->getName()}' id='{$this->getName()}false' value='false'>
                  <label class='form-check-label' for='{$this->getName()}false'>No</label>
              </div>
          </div>
        </div>
EOT;
    }*/
}