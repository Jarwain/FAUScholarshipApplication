<?php
namespace ScholarshipApi\Model\Requirement;

class RequirementRepository implements RequirementStore{
    var $database;
    var $cache; // TODO: (low priority)

    var $requirements;

    function __construct(RequirementStore $database){
        $this->database = $database;
    }

    function getAll(){
        $this->requirements = $this->requirements ?? 
            $this->database->getAll();

        return $this->requirements;
    }

    function get($code, $category = NULL, $qualifier_id = NULL){
        $requirement = $this->requirements[$code] ?? 
            $this->database->get($code, $category, $qualifier_id);

        return $requirement;
    }

    function create($code, $data){
        return $this->database->create($code, $data);
    }
}
