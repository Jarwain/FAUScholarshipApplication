<?php
namespace ScholarshipApi\Model\Scholarship;

class ScholarshipFactory{

    function __construct(){

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
                return OnlineScholarship::DataMap($data);
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