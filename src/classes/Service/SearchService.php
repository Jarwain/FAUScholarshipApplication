<?php
namespace ScholarshipApi\Service;

use ScholarshipApi\Model\Qualifier\QualifierRepository;
use ScholarshipApi\Model\Application\ApplicationRepository;
use ScholarshipApi\Model\Student\Student;

class SearchService{
    var $qualifiers;
    var $applications;
 
    function __construct(   QualifierRepository $qualifiers, 
                            ApplicationRepository $applications) {
        $this->qualifiers = $qualifiers;
        $this->applications = $applications;
    }

    function validateQualifications($qualifications) {
        $result = [];
        $qualifiers = $this->qualifiers->getAllByName();
        foreach ($qualifications as $key => $qualification) { 
            if(array_key_exists($key, $qualifiers)){
                $result[$key] = $qualifiers[$key]->validate($qualification);
            }
        }
        return $result;
    }

    function searchScholarships($data, $params){
        $znumber = $params['znumber'] ?? NULL;
        if($znumber) {
            $apps = $this->applications->getByZnumber($znumber);
            $codes = array_column($apps, 'code');
            foreach($codes as $code){
                $data[$code]->setStudentApplied();
            }
        }
        $result = $this->validateQualifications($params);
        // If there exist qualifications
        if(!empty($result)){
            $student = new Student($znumber, Null, Null, Null);
            $qualifiers = $this->qualifiers->getAllByName();
            foreach($result as $qualifier => $val){
                // Only use valid qualifications
                if($val === True){
                    $id = $qualifiers[$qualifier]->getId();
                    $student->addQualification($id, $params[$qualifier]);
                }
            }

            foreach($data as $scholarship){
                $eligible = $scholarship->checkEligibility($student);
                $scholarship->setEligibility($eligible);
            }
        }
        
        return $data;
    }
}
