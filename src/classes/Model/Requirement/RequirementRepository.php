<?php
namespace ScholarshipApi\Model\Requirement;

use ScholarshipApi\Model\AbstractRepository;

class RequirementRepository extends AbstractRepository implements RequirementStore{
    function bind($code, $data){
        foreach($data as $requirement){
            $requirement['code'] = $code;
            $this->create($requirement);
        }
    }
}
