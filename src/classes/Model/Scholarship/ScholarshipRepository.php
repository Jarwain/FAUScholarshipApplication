<?php
namespace ScholarshipApi\Model\Scholarship;


class ScholarshipRepository implements ScholarshipStore{
    private $offline = Null;
    private $online = Null;

    private $database;

    function __construct(ScholarshipStore $database){
        $this->database = $database;
    }

    function getOffline(){
        $this->offline = $this->offline ?? 
            $this->database->getOffline();

        return $this->offline;
    }

    function getOnline(){
        $this->online = $this->online ?? 
            $this->database->getOnline();

        return $this->online;
    }

    function getAll(){
        return $this->getOffline() + $this->getOnline();
    }

    function get($code){
        $scholarship = $this->offline[$code] ?? 
            $this->online[$code] ?? 
            $this->database->get($code);
        return $scholarship;
    }

    function create($scholarship){
        return $this->database->create($scholarship);
    }

}
