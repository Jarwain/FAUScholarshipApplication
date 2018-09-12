<?php
namespace ScholarshipApi\Service;

use ScholarshipApi\Repository\QualifierRepository;
use ScholarshipApi\Repository\RequirementRepository;

class SearchService{
    var $qualifiers;
    var $applications;
 
    function __construct($qualifiers, $applications){
        $this->qualifiers = $qualifiers;
        $this->applications = $applications;
    }

    function searchScholarships($params){
        $result = $this->validateQualification($params);;
        
        // Follow up with Requirement validation
        
        return $result;
    }

    function validateQualifications($params) {
        foreach ($params as $key => $value) { 
            if($key == 'znumber') {
                $apps = $this->applications->getByZnumber($value);
            } else if(in_array($key, $qualifiers)) {
                $result[$key] = $qualifiers[$key]->validate($value);
            }
        }
    }
}
