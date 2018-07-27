<?php
namespace ScholarshipApi\Model\Qualifier;

use Respect\Validation\Validator as v;

class SelectQualifier extends Qualifier{

    function __construct($id, $name, $question, $props = []){
        $this->type = parent::TYPE_SELECT; 
        $this->setRequiredProps(['haystack']);
        $this->setOptionalProps(['multi']);

        parent::__construct($id, $name, $question, $props);
    }

    function getHaystack(){
        return $this->getProp('haystack');
    }

    function isMulti(){
        return $this->getProp('multi') ?? False;
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