<?php
namespace ScholarshipApi\Model\Question;

class QuestionFactory{
    function __construct(){

    }

    function groupByScholarship($data){
        $scholarships = [];
        foreach($data as $sQ){
            $scholarships[$sQ['code']][] = $sQ['question'];
        }
        return $scholarships;
    }

    function bulkInitialize($data){
        $question = [];

        foreach($data as $q){
            $id = $q['id'];
            $question[$id] = $this->initialize($q);
        }
        
        return $question;
    }

    function initialize($data){
        if(isset($data['options']) && is_string($data['options'])){
            $data['options'] = json_decode($data['options'], true);
        }
        switch($data['type']){
            case 'essay':
                return EssayQuestion::DataMap($data);
                break;
            case 'file':
                return FileQuestion::DataMap($data);
                break;
            case 'video':
                return VideoQuestion::DataMap($data);
                break;
            default:
                throw new \DomainException("Invalid Question Type");
                break;
        }
    }
}