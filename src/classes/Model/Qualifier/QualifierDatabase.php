<?php
namespace ScholarshipApi\Model\Qualifier;

class QualifierDatabase implements QualifierStore{
    var $db;
    var $factory;

    function __construct(\PDO $db){
        $this->db = $db;
        $this->factory = new QualifierFactory();
    }

    function getAll(){
        $query = "SELECT id, name, type, question, props
                    FROM `qualifier`";
        $result = $this->db->query($query)->fetchAll();
        
        return $this->factory->bulkInitialize($result);
    }

    function get($id){
        $query = "SELECT id, name, type, question, props
                    FROM `qualifier` 
                    WHERE id = :id";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        if(is_null($result) || !$result){
            throw new \OutOfBoundsException ("Qualifier '$id' doesn't exist.");
        }

        return $this->factory->initialize($result);
    }

    function save($item){
        throw new Exception("Save qualifier not implemented yet");
        /*$query = "INSERT INTO `qualifier` (`name`,`type`,`question`,`props`)
                    VALUES (:name, :type, :question, :props)
                    ON DUPLICATE KEY UPDATE 
                        name=VALUES(name), type=VALUES(type), 
                        question=VALUES(question), props=VALUES(props)";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':name', $item['name'], \PDO::PARAM_STR);
        $stmnt->bindParam(':type', $item['type'], \PDO::PARAM_STR);
        $stmnt->bindParam(':question', $item['question'], \PDO::PARAM_INT);
        $stmnt->bindParam(':props', $item['props'], \PDO::PARAM_INT);
        $stmnt->execute();*/
    }

    function delete($id){
        $query = "DELETE FROM `qualifier`
                    WHERE id = :id";
        $stmnt = $this->db->prepare($query);
        $stmnt->bindParam(':id', $id, \PDO::PARAM_STR);
        return $stmnt->execute();
    }
}