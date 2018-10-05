<?php
namespace ScholarshipApi\Model\Requirement;

class Requirement implements \JsonSerializable{
    protected $id;
    protected $category;
    protected $qualifier;
    protected $valid;

    // TODO: (maybe)Refactor so that there's $pass and $fail

    function __construct($id, $category, $qualifier, $valid){
        $this->id = $id;
        $this->category = $category;
        $this->qualifier = $qualifier;
        $this->valid = $valid;
    }


    function jsonSerialize(){
        return [
            'id' => $this->getId(),
            'category' => $this->getCategory(),
            'qualifier_id' => $this->getQualifierId(),
            'valid' => $this->getValid()
        ];
    }

    function validate($value){
        return $this->qualifier->validate($value, $this->valid);
    }

    function getId(){
        return $this->id;
    }

    function getCategory(){
        return $this->category;
    }

    function getQualifier(){
        return $this->qualifier;
    }

    function getQualifierId(){
        return $this->qualifier->getId();
    }

    function getValid(){
        return $this->valid;
    }
}
