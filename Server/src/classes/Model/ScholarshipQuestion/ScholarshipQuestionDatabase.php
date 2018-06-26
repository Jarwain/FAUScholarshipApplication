<?php
namespace ScholarshipApi\Model\ScholarshipQuestion;

class ScholarshipQuestionDatabase implements ScholarshipQuestionStore{
    var $db;
    var $factory;

    function __construct(\PDO $db, ScholarshipQuestionFactory $factory){
        $this->db = $db;
        $this->factory = $factory;
    }

    public function getAll(){
        $query = "SELECT id, code, question
                    FROM `scholarship_questions`";
        $result = $this->db->query($query)->fetchAll();
        
        return $this->factory->initialize($result);
    }

    public function get($code){
        $query = "SELECT id, code, question
                    FROM `scholarship_questions`
                    WHERE code = :code";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        return $this->factory->initialize($result);
    } 

    function saveQuestionToScholarship($code, $questionId){
        
    }
}
