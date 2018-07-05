<?php
namespace ScholarshipApi\Model\Question;

class QuestionDatabase implements QuestionStore{
    var $db;
    var $factory;

    function __construct(\PDO $db){
        $this->db = $db;
        $this->factory = new QuestionFactory();
    }

    function getAll(){
        $query = "SELECT id, type, question, options
                    FROM `question`";
        $result = $this->db->query($query)->fetchAll();
        
        return $this->factory->bulkInitialize($result);
    }

    function get($id){
        $query = "SELECT id, type, question, options
                    FROM `question` 
                    WHERE id = :id";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        if(is_null($result) || !$result){
            throw new \OutOfBoundsException ("Question '$id' doesn't exist.");
        }

        return $this->factory->initialize($result);
    }

    function create($item){

    }

}
