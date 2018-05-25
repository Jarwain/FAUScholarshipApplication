<?php
namespace ScholarshipApi\Model\Scholarship;

class ScholarshipFactory{

    static function bulkInitialize($type, $data, array $requirements = Null, array $questions = Null){
        $scholarships = [];

        foreach($data as $sch){
            $code = $sch['code'];
            $require = $requirements;
            $question = $questions;

            $scholarships[$code] = self::initialize($type, $sch, $require, $question);
        }
        
        return $scholarships;
    }

    static function initialize($type, $data, array $requirements = Null, array $questions = Null){
        switch($type){
            case 'online':
                return OnlineScholarship::Factory($data, $requirements, $questions);
                break;
            case 'offline':
                return OfflineScholarship::Factory($data);
                break;
            default:
                throw new \DomainException("Invalid Scholarship Type");
                break;
        }
    }
}