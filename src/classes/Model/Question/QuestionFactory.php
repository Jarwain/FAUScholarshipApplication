<?php
namespace ScholarshipApi\Model\Question;

class QuestionFactory{
    function __construct(){

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
            case Question::TYPE_ESSAY:
                return new EssayQuestion($data['id'], $data['question'], $data['options']);
                break;
            case Question::TYPE_FILE:
                return new FileQuestion($data['id'], $data['question'], $data['options']);
                break;
            case Question::TYPE_VIDEO:
                return new VideoQuestion($data['id'], $data['question'], $data['options']);
                break;
            default:
                throw new \DomainException("Invalid Question Type");
                break;
        }
    }
}