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
        $query = "SELECT id, type, question, props
                    FROM `question`";
        $result = $this->db->query($query)->fetchAll();
        
        return $this->factory->bulkInitialize($result);
    }

    function get($id){
        $query = "SELECT id, type, question, props
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

    function save($item){
        throw new Exception("Save question not implemented yet");
        /*$query = "INSERT INTO `question` (`name`,`description`,`active`,`max`)
                    VALUES (:code, :name, :description, :active, :max)
                    ON DUPLICATE KEY UPDATE 
                        name=VALUES(name), description=VALUES(description), 
                        active=VALUES(active), max=VALUES(max)";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':code', $sch['code'], \PDO::PARAM_STR);
        $stmnt->bindParam(':name', $sch['name'], \PDO::PARAM_STR);
        $stmnt->bindParam(':description', $sch['description'], \PDO::PARAM_STR);
        $stmnt->bindParam(':active', $sch['active'], \PDO::PARAM_INT);
        $stmnt->bindParam(':max', $sch['max'], \PDO::PARAM_INT);
        $stmnt->execute();*/
    }

    function delete($id){
        $query = "DELETE FROM `question`
                    WHERE id = :id";
        $stmnt = $this->db->prepare($query);
        $stmnt->bindParam(':id', $id, \PDO::PARAM_STR);
        return $stmnt->execute();
    }

}
