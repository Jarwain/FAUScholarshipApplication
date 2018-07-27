<?php
namespace ScholarshipApi\Model\ScholarshipQuestion;

use ScholarshipApi\Model\AbstractRepository;

class ScholarshipQuestionRepository extends AbstractRepository implements ScholarshipQuestionStore{
    function save($data){
        foreach($data as $code => $questions){
            // Delete what exists
            $this->delete($code);
            $toSave = [];
            foreach($questions as $questionId){
                $toSave[] = [
                    "code" => $code,
                    "questionId" => $questionId
                ];
            }
            // Save it all anew
            parent::save($toSave);
        }
    }
}
