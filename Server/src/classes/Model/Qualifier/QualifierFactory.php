<?php
namespace ScholarshipApi\Model\Qualifier;

class QualifierFactory{
    function __construct(){

    }

    function bulkInitialize($data){
        $qualifiers = [];

        foreach($data as $q){
            $id = $q['id'];
            if(isset($q['options']) && is_string($q['options'])){
                $q['options'] = json_decode($q['options'], true);
            }
            $qualifiers[$id] = $this->initialize($q);
        }
        
        return $qualifiers;
    }

    function initialize($data){
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