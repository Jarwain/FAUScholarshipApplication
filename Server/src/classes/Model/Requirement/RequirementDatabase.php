<?php
namespace ScholarshipApi\Model\Requirement;

class RequirementDatabase implements RequirementStore {
    var $db;
    var $factory;

    function __construct(\PDO $db, RequirementFactory $factory){
        $this->db = $db;
        $this->factory = $factory;
    }

    public function getAll(){
        $query = "SELECT id, sch_code, category, qualifier_id, valid
                    FROM `scholarship_requirements`";
        $result = $this->db->query($query)->fetchAll();

        return $this->factory->bulkInitialize($result);
    }

    public function get($code, $category = NULL, $qualifier_id = NULL){
        $query = "SELECT id, sch_code, category, qualifier_id, valid
                    FROM `scholarship_requirements` 
                    WHERE sch_code = :code";
        if(isset($category)){
            $query .=  " AND category = :category";
        }
        if(isset($qualifier_id)){
            $query .= " AND qualifier_id = :qid";
        }
        $stmnt = $this->db->prepare($query);

        if(isset($category)){
            $stmnt->bindParam(':category', $category, \PDO::PARAM_STR);
        }
        if(isset($qualifier_id)){
            $stmnt->bindParam(':qid', $qualifier_id, \PDO::PARAM_STR);
        }
        $stmnt->bindParam(':code', $code, \PDO::PARAM_STR);

        $stmnt->execute();
        $result = $stmnt->fetchAll();

        return $this->factory->initialize($result);
    } 
}