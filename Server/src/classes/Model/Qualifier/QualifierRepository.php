<?php
namespace ScholarshipApi\Model\Qualifier;

class QualifierRepository implements QualifierStore{
    private $qualifiers = Null;

    private $database;

    function __construct(QualifierStore $database){
        $this->database = $database;
    }

    function getAll(){
        $this->qualifiers = $this->qualifiers ?? 
            $this->database->getAll();
        return $this->qualifiers;
    }

    function get($id){
        $q = $this->qualifiers[$id] ??
            $this->database->get($id);
        return $q;
    }
}