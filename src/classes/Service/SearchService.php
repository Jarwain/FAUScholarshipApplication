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
        if($params['znumber']) {
            $apps = $this->applications->getByZnumber($params['znumber']);
            $codes = array_column($apps, 'code');
            foreach($codes as $code){
                $data[$code]->setStudentApplied();
            }
        }
        $result = $this->validateQualifications($params);
        // If there exist qualifications
        if(!empty($result)){
            $qualifications = [];
            foreach($result as $key=>$val){
                if($val === True){
                    $qualifications[$key] = $params[$key];
                }
            }
            foreach($data as $scholarship){
                $qualifies = $this->studentQualifies($qualifications, $scholarship);
                $scholarship->setStudentQualifies($qualifies);
            }
        }
        
        return $data;
    }

    function studentQualifies($qualifications, $scholarship){
        $categories = $scholarship->getRequirementCategories();
        $categoryCount = count($categories);
        
        if(!$categoryCount) return True;
        
        $results = [];
        foreach($categories as $category){
            $results[$category] = studentPassesRequirements($qualifications, $scholarship->getRequirements($category));
        }
    }

    function studentPassesRequirements($qualifications, $requirements) {

    }
}
