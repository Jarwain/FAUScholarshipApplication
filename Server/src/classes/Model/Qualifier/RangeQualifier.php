<?php
namespace ScholarshipApi\Model\Qualifier;

use Respect\Validation\Validator as v;

class RangeQualifier extends Qualifier{
    var $range;

    function __construct($id, $name, $type, $question, $range, $options = []){
        parent::__construct($id, $name, $type, $question, $options);

        $this->range = $range;
    }

    static function DataMap(array $data){
        $opt = $data['options'];
        $param = $opt['param'];
        $options = [
            'length' => $opt['length'] ?? Null,
            'length_message' => $opt['length_message'] ?? Null
        ];
        return new RangeQualifier($data['id'], $data['name'], $data['type'], $data['question'], 
                                    $param, $options);
    }

    /**
     * Check if term is between $start and $end. 
     * $start/$end are defined by $valid if set, else defined by object state
     * Returns True on success, returns reason on failure
     */
    function validate($term, $valid = Null){
        // If length is set and $term length is not what it should be, return an error
        if(isset($this->options['length']) && strlen($term) !== $this->options['length']){
            return $this->options['length_message'];
        }

        $start = $valid[0] ?? $this->range[0];
        $end = $valid[1] ?? $this->range[1];
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