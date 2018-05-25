<?php
namespace ScholarshipApi\Model\Qualifier;

class QualifierDatabase{
    var $db;

    function __construct(\PDO $db, QualifierFactory $factory){
        $this->db = $db;
    }

    public function getAll(){
        $query = "SELECT id, name, type, question, options
                    FROM `qualifier`";
        $result = $this->db->query($query)->fetchAll();
        
        $result['options'] = json_decode($result['options'], true);
        
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

        $result['options'] = json_decode($result['options'], true);

        return $this->factory->initialize($result);
    } 
}