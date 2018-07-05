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
        $query = "SELECT id, name, type, question, options
                    FROM `qualifier`";
        $result = $this->db->query($query)->fetchAll();
        
        return $this->factory->bulkInitialize($result);
    }

    function get($id){
        $query = "SELECT id, name, type, question, options
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

    function create($item){
        
    }
}