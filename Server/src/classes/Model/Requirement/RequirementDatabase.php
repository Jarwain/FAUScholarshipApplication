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

    public function get($code){
        $query = "SELECT id, sch_code, category, qualifier_id, valid
                    FROM `scholarship_requirements` 
                    WHERE sch_code = :code";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':code', $code, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetchAll();

        return $this->factory->initialize($result);
    } 

    public function create($code, $data){
        $query = "INSERT ";
    }
}
