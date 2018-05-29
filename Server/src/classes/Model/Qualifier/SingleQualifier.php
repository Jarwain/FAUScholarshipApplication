<?php
namespace ScholarshipApi\Model\Qualifier;

use Respect\Validation\Validator as v;

class SingleQualifier extends Qualifier{
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