<?php
namespace ScholarshipApi\Model\Question;

class QuestionDatabase implements QuestionStore{
    var $db;
    var $factory;

    function __construct(\PDO $db, QuestionFactory $factory){
        $this->db = $db;
        $this->factory = $factory;
    }

    public function getAll(){
        $query = "SELECT id, type, question, options
                    FROM `question`";
        $result = $this->db->query($query)->fetchAll();
        
        return $this->factory->bulkInitialize($result);
    }

    public function get($id){
        $query = "SELECT id, type, question, options
                    FROM `question` 
                    WHERE id = :id";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        return $this->factory->initialize($result);
    }

    function getAllByScholarship(){
        $query = "SELECT id, code, question
                    FROM `scholarship_questions`";
        $result = $this->db->query($query)->fetchAll();
        
        return $result;//$this->factory->groupByScholarship($result);
    }
    
    function getByScholarship($code){
        $query = "SELECT id, code, question
                    FROM `scholarship_questions`
                    WHERE code = :code";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        return $result;//$this->factory->groupByScholarship($result);
    } 
}