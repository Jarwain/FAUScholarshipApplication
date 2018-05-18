<?php
namespace ScholarshipApi\Entity;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;


class Qualifier {
    var $id;
    var $name;
    var $form; // bool, range, single (select), multi (select)
    var $question;
    var $param;
    var $regex;
    var $regex_message;

    function __construct($id, $name, $form, $question, $param = NULL, $regex = NULL, $regex_message = NULL){
        $this->id = $id;
        $this->name = $name;
        $this->form = $form;
        $this->question = $question;
        $this->param = $param;
        $this->regex = $regex;
        $this->regex_message = $regex_message;
    }

    function validate($term, $valid = NULL){
        // If Regex is Set&!null AND term fails the regex check
        try{
            if(isset($this->regex) && !v::regex($this->regex)->validate($term)){
                throw new \UnexpectedValueException($this->regex_message);
            }

            $param = $valid ?? $this->param;
            if(!is_array($param) && !is_null($param))
                throw new \UnexpectedValueException("Param is not array " . json_encode($param));

            switch($this->form){
                case 'bool':
                    // $param is either [true], [false], or [true, false]
                    $validator = v::boolVal()->in($param);
                    break;
                case 'range':
                    // $param should be [num, num]
                    $validator = v::numeric()->between($param[0], $param[1]);
                    break;
                case 'single':
                    $validator = v::stringType()->in($param);
                    break;
                case 'multi':
                    $container = array_map(function($e){ return v::contains($e);}, $param);
                    $validator = v::arrayVal()->oneOf(...$container);
                    break;
                default: 
                    throw new \DomainException("Invalid Qualifier type $this->form");
            }
            $validator->assert($term);
        } catch(NestedValidationException $e) {
            return [false, $e->getMessages()];
        } catch(UnexpectedValueException $e) {
            return [false, $e->getMessage()];
        }
        return [true];
    }

    static function Factory(array $data){
        $param = isset($data['param']) ? json_decode($data['param'], true) : NULL;
            $r = isset($data['regex']) ? json_decode($data['regex'], true) : NULL;
        $regex = $r[0]; // if not set, it's null
        $msg = $r[1];

        $type = $data['form'];
        switch($type){
            case 'bool':
                return new Qualifier($data['id'], $data['name'], $data['form'], $data['question'], [true,false]);
            break;
            case 'range':
                return new Qualifier($data['id'], $data['name'], $data['form'], $data['question'], $param, $regex, $msg);
            break;
            case 'single':
                return new Qualifier($data['id'], $data['name'], $data['form'], $data['question'], $param, $regex, $msg);
            break;
            case 'multi':
                return new Qualifier($data['id'], $data['name'], $data['form'], $data['question'], $param, $regex, $msg);
            break;
        }

        throw new \DomainException("Invalid Qualifier type $type");
    }
}