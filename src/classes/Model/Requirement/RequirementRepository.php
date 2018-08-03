<?php
namespace ScholarshipApi\Model\Requirement;

use ScholarshipApi\Model\AbstractRepository;

class RequirementRepository extends AbstractRepository implements RequirementStore{
    function save($data){
        foreach($data as $code => $categories){
            // Delete what exists
            $this->delete($code);
            $toSave = [];
            foreach($requirements as $requirement){
                $requirement['code'] = $code;
                $toSave[] = $requirement;
            }
            // Save it all anew
            parent::save($toSave);
        }
    }
}
