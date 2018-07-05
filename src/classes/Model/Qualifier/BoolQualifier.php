<?php
namespace ScholarshipApi\Model\Qualifier;

use Respect\Validation\Validator as v;

class BoolQualifier extends Qualifier{

    function __construct($id, $name, $type, $question){
        parent::__construct($id, $name, $type, $question);
    }

    static function DataMap(array $data){
        return new BoolQualifier($data['id'], $data['name'], $data['type'], $data['question']);
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

}