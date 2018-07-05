<?php
namespace ScholarshipApi\Model\Scholarship;

use ScholarshipApi\Model\Requirement\RequirementStore;
use ScholarshipApi\Model\ScholarshipQuestion\ScholarshipQuestionStore;

class ScholarshipFactory{
    private $requirements;
    private $questions;

    function __construct(RequirementStore $requirements, ScholarshipQuestionStore $questions){
        $this->requirements = $requirements;
        $this->questions = $questions;
    }

    function bulkInitialize($type, $data){
        $scholarships = [];

        $this->requirements->getAll(); // Cache Requirements & Questions
        $this->questions->getAll(); // This will minimize load on the DB

        foreach($data as $sch){
            $code = $sch['code'];
            $scholarships[$code] = $this->initialize($type, $sch);
        }
        
        return $scholarships;
    }

    function initialize($type, $data){
        switch($type){
            case 'online':
                $sch = new OnlineScholarship(
                    $data['code'], $data['name'], $data['description'], $data['active'], 
                    $data['max']);
                $sch->addRequirements($this->requirements->get($sch->getCode()));
                $sch->addQuestions($this->questions->get($sch->getCode()));
                // TODO: Set URL & Deadline based on application details
                return $sch;
                break;
            case 'offline':
                return new OfflineScholarship(
                    $data['code'], $data['name'], $data['description'], $data['active'], 
                    $data['internal'], $data['url'], $data['deadline']);
                break;
            default:
                throw new \DomainException("Invalid Scholarship Type");
                break;
        }
    }

}
