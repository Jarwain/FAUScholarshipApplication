<?php
namespace ScholarshipApi\Model\Qualifier;

class QualifierFactory{
    function __construct(){

    }

    function bulkInitialize($data){
        $qualifiers = [];

        foreach($data as $q){
            $id = $q['id'];
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
                return OfflineScholarship::DataMap($data);
                break;
            case 'single':
                return OfflineScholarship::DataMap($data);
                break;
            case 'multi':
                return OfflineScholarship::DataMap($data);
                break;
            default:
                throw new \DomainException("Invalid Qualifier Type");
                break;
        }
    }
}