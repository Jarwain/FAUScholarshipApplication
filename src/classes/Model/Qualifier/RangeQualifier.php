<?php
namespace ScholarshipApi\Model\Qualifier;

use Respect\Validation\Validator as v;

class RangeQualifier extends Qualifier{

    function __construct($id, $name, $question, $options = []){
        $this->type = parent::TYPE_RANGE; 
        $this->requiredOptions = ['range'];
        
        parent::__construct($id, $name, $question, $options);
    }

    function getMin(){
        return $this->getOption('range')[0];
    }
    function getMax(){
        return $this->getOption('range')[1];
    }
    function getStep(){
        return $this->getOption('step');
    }

    function renderInput(){
        $out = "
        <div class='form-group'>
            <label class='col-sm-3 col-form-label' for='{$this->getName()}'>{$this->getQuestion()}</label>
            <input type='range' class='custom-range' min='{$this->getMin()}' max='{$this->getMax()}' step='{$this->getStep()}' id='{$this->getName()}'>
        </div>
        ";
        echo $out;
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

}