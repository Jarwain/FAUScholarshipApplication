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
        if(isset($data['options']) && is_string($data['options'])){
            $data['options'] = json_decode($data['options'], true);
        }
        switch($data['type']){
            case 'bool':
                return BoolQualifier::DataMap($data);
                break;
            case 'range':
                return RangeQualifier::DataMap($data);
                break;
            case 'single':
                return SingleQualifier::DataMap($data);
                break;
            case 'multi':
                return MultiQualifier::DataMap($data);
                break;
            default:
                throw new \DomainException("Invalid Qualifier Type");
                break;
        }
    }
}