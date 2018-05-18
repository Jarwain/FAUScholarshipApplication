<?php
namespace ScholarshipApi\Service;

use ScholarshipApi\Repository\{
    ScholarshipRepository,
    QualifierRepository,
    RequirementRepository
};

class ScholarshipService{
    protected $scholarshipRepository;
    protected $requirementRepository;
    protected $qualifierRepository;

    function __construct($db){
        $this->scholarshipRepository = new ScholarshipRepository($db);
        $this->requirementRepository = new RequirementRepository($db);
    }

    function getScholarship($code){
        return $this->scholarshipRepository->get($code);
    }

    function getAllScholarships($core = FALSE, $online = NULL){
        if($online === FALSE){
            $scholarships = $this->scholarshipRepository->getAllOffline();
        } else {
            $scholarships = is_null($online) ? 
                $this->scholarshipRepository->getAll($core) : 
                $this->scholarshipRepository->getAllOnline($core);
        }
        return $scholarships;
    }
}