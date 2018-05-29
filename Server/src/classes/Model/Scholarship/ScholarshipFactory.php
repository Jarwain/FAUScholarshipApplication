<?php
namespace ScholarshipApi\Model\Scholarship;

use ScholarshipApi\Model\Requirement\RequirementStore;

class ScholarshipFactory{
    private $requirements;

    function __construct(RequirementStore $requirements){
        $this->requirements = $requirements;
    }

    function bulkInitialize($type, $data){
        $scholarships = [];

        foreach($data as $sch){
            $code = $sch['code'];
            $scholarships[$code] = $this->initialize($type, $sch);
        }
        
        return $scholarships;
    }

    function initialize($type, $data){
        switch($type){
            case 'online':
                $sch = OnlineScholarship::DataMap($data);
                $sch->addRequirements($this->requirements->get($sch->getCode()));
                return $sch;
                break;
            case 'offline':
                return OfflineScholarship::DataMap($data);
                break;
            default:
                throw new \DomainException("Invalid Scholarship Type");
                break;
        }
    }
}