<?php
namespace ScholarshipApi\Service;

use ScholarshipApi\Repository\QualifierRepository;
use ScholarshipApi\Repository\RequirementRepository;

class SearchService{
    var $qualifierRepository;
 
    function __construct(&$container){
        $this->qualifierRepository = new QualifierRepository($container->db);
    }

    function getQualifiers(){
        return $this->qualifierRepository->getAll();
    }

    function searchScholarships($params){
        $result = [];
        $qualifiers = $this->getQualifiers();
        // array_reduce to ensure All are true
        // Follow up with Requirement validation
        foreach ($params as $key => $value) { 
            $result[$key] = $qualifiers[$key]->validate($value);
        }
        return $result;
    }
}