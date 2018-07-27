<?php
namespace ScholarshipApi\Model\Requirement;

use ScholarshipApi\Model\Qualifier\QualifierStore;

class RequirementFactory{
    private $qualifiers;

    function __construct(QualifierStore $qualifiers){
        $this->qualifiers = $qualifiers;
    }

    /**
     * Initializes all requirements for a single scholarship
     */
    function initialize($data){
        $requirements = [];
        foreach($data as $req){
            $req['qualifier'] = $this->qualifiers->get($req['qualifier_id']);
            if(isset($req['valid']) && is_string($req['valid'])){
                $req['valid'] = json_decode($req['valid'], true);
            }
            $requirements[$req['sch_code']][$req['category']][] = new Requirement($req['id'], $req['category'], $req['qualifier'], $req['valid']);
        }
        return $requirements;
    }
}