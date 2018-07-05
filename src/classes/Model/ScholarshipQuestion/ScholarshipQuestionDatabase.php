<?php
namespace ScholarshipApi\Model\ScholarshipQuestion;

use ScholarshipApi\Model\Question\QuestionStore;

class ScholarshipQuestionDatabase implements ScholarshipQuestionStore{
    var $db;
    var $factory;

    function __construct(\PDO $db, QuestionStore $questions){
        $this->db = $db;
        $this->factory = new ScholarshipQuestionFactory($questions);
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

        $stmnt->bindParam(':code', $code, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        return $this->factory->initialize($result);
    } 

    function create($data){
        $query = "INSERT INTO `scholarship_questions` (`code`,`question`)
            VALUES (:code, :question)";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':code', $data['code'], \PDO::PARAM_STR);
        $stmnt->bindParam(':question', $data['question'], \PDO::PARAM_INT);
        $stmnt->execute();

        return $this->db->lastInsertId();
    }
}
