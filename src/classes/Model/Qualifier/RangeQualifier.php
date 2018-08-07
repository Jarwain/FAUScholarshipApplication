<?php
namespace ScholarshipApi\Model\Qualifier;

use Respect\Validation\Validator as v;

class RangeQualifier extends Qualifier{

    function __construct($id, $name, $question, $props = []){
        $this->type = parent::TYPE_RANGE; 
        $this->setRequiredProps(['min','max']);
        $this->setOptionalProps(['step']);
        
        parent::__construct($id, $name, $question, $props);
    }

    function getMin(){
        return $this->getProp('min');
    }
    function getMax(){
        return $this->getProp('max');
    }
    function getStep(){
        return $this->getProp('step');
    }

    /**
     * Check if term is between $start and $end. 
     * $start/$end are defined by $valid if set, else defined by object state
     * Returns True on success, returns reason on failure
     */
    function validate($term, $valid = Null){
        /*// If length is set and $term length is not what it should be, return an error
        if(isset($this->options['length']) && strlen($term) !== $this->options['length']){
            return $this->options['length_message'];
        }*/

        $start = $valid[0] ?? $this->getMin();
        $end = $valid[1] ?? $this->getMax();
        $validator = v::floatVal()->between($start, $end, True);

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
        <div class='form-group'>
          <label class='col-sm-3 col-form-label' for='{$this->getName()}'>{$this->getQuestion()}</label>
          <input type='range' class='custom-range' min='{$this->getMin()}' max='{$this->getMax()}' step='{$this->getStep()}' id='{$this->getName()}'>
        </div>
EOT;
    }*/
}