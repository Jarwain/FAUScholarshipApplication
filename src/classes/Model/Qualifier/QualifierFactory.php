<?php
namespace ScholarshipApi\Model\Qualifier;

class QualifierFactory{

    function bulkInitialize($data){
        $qualifiers = [];

        foreach($data as $q){
            $id = $q['id'];
            $qualifiers[$id] = $this->initialize($q);
        }
        
        return $qualifiers;
    }

    function initialize($data){
        if(isset($data['props']) && is_string($data['props'])){
            $data['props'] = json_decode($data['props'], true);
        }
        switch($data['type']){
            case Qualifier::TYPE_BOOL:
                return new BoolQualifier($data['id'], $data['name'], $data['question'], $data['props']);
                break;
            case Qualifier::TYPE_RANGE:
                return new RangeQualifier($data['id'], $data['name'], $data['question'], $data['props']);
                break;
            case Qualifier::TYPE_SELECT:
                return new SelectQualifier($data['id'], $data['name'], $data['question'], $data['props']);
                break;
            default:
                throw new \DomainException("Invalid Qualifier Type");
                break;
        }
    }
}