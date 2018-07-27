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
        $query = "INSERT INTO `question` (`id`,`question`,`type`,`props`)
                    VALUES (:id, :question, :type, :props, :max)
                    ON DUPLICATE KEY UPDATE 
                        question=VALUES(question), type=VALUES(type), 
                        props=VALUES(props)";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':id', $item['id'], \PDO::PARAM_STR);
        $stmnt->bindParam(':question', $item['question'], \PDO::PARAM_STR);
        $stmnt->bindParam(':type', $item['type'], \PDO::PARAM_STR);
        $props = json_encode($item['props'], JSON_NUMERIC_CHECK);
        $stmnt->bindParam(':props', $props, \PDO::PARAM_INT);
        $stmnt->execute();
    }

    function delete($id){
        $query = "DELETE FROM `question`
                    WHERE id = :id";
        $stmnt = $this->db->prepare($query);
        $stmnt->bindParam(':id', $id, \PDO::PARAM_STR);
        return $stmnt->execute();
    }

}
