<?php
namespace ScholarshipApi\Repository;

use ScholarshipApi\Repository\QualifierRepository;
use ScholarshipApi\Repository\DataAccessObject\RequirementDatabase;
use ScholarshipApi\Entity\Requirement;

class RequirementRepository{
    var $database;
    var $cache; // TODO: (low priority)

    var $qualifierRepository;

    function __construct(\PDO $db){
        $this->database = new RequirementDatabase($db);

        $this->qualifierRepository = new QualifierRepository($db);
    }

    function getAll(){
        $data = $this->database->getAll();
        $requirements = Requirement::BulkFactory($data, $this->qualifierRepository->getAll());

        return $requirements;
    }

    function get($code, $category = NULL, $qualifier_id = NULL){
        $data = $this->database->get($code, $category, $qualifier_id);
        $requirements = Requirement::BulkFactory($data, $this->qualifierRepository->getAll());

        return $requirements[$code];
    }

    function getAllTest(){
        $data = $this->database->getAllTest();
        // $requirements = Requirement::BulkFactory($data, $this->qualifierRepository->getAll());

        return $data;
    }
}