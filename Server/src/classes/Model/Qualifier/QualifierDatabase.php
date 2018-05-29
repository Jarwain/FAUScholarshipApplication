<?php
namespace ScholarshipApi\Model\Qualifier;

class QualifierDatabase implements QualifierStore{
    var $db;
    var $factory;

    function __construct(\PDO $db, QualifierFactory $factory){
        $this->db = $db;
        $this->factory = $factory;
    }

    public function getAll(){
        $query = "SELECT id, name, type, question, options
                    FROM `qualifier`";
        $result = $this->db->query($query)->fetchAll();
        
        return $this->factory->bulkInitialize($result);
    }

    public function get($id){
        $query = "SELECT id, name, type, question, options
                    FROM `qualifier` 
                    WHERE id = :id";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        return $this->factory->initialize($result);
    } 
}