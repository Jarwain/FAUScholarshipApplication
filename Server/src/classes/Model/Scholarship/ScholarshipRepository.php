<?php
namespace ScholarshipApi\Model\Scholarship;


class ScholarshipRepository{
    var $store;

    var $requirementRepository;

    function __construct(\PDO $db){
        $this->database = new ScholarshipDatabase($db);

        $this->requirementRepository = new RequirementRepository($db);
    }

    function getAllOffline(){
        $data = $this->database->getAllOffline();
        $scholarships = OfflineScholarship::BulkFactory($data);

        return $scholarships;
    }

    function getAllOnline($core = FALSE){
        $data = $this->database->getAllOnline();
        $scholarships = OnlineScholarship::BulkFactory($data);

        if(!$core){
            $requirements = $this->requirementRepository->getAll();
            foreach($requirements as $code=>$reqs){
                $scholarships[$code]->addRequirements($reqs);
            }
        }

        return $scholarships;
    }

    function getAll($core = FALSE){
        return $this->getAllOffline() + $this->getAllOnline($core);
    }

    function get($code){
        list($scholarship, $isOnline) = $this->database->get($code);
        if($isOnline){
            $scholarship = OnlineScholarship::Factory($scholarship);
            $scholarship->addRequirements($this->requirementRepository->get($code));
        } else {
            $scholarship = OfflineScholarship::Factory($scholarship);
        }
        return $scholarship;
    }

}