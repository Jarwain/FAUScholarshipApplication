<?php
namespace ScholarshipApi\Model\Requirement;

use ScholarshipApi\Model\Qualifier\QualifierStore;

class RequirementDatabase implements RequirementStore {
    var $db;
    var $factory;

    function __construct(\PDO $db, QualifierStore $qualifiers){
        $this->db = $db;
        $this->factory = new RequirementFactory($qualifiers);
    }

    public function getAll(){
        $query = "SELECT id, sch_code, category, qualifier_id, valid
                    FROM `scholarship_requirements`";
        $result = $this->db->query($query)->fetchAll();

        return $this->factory->initialize($result);
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

    public function save($data){
        $query = "INSERT INTO `scholarship_requirements` (`sch_code`,`category`,`qualifier_id`,`valid`)
            VALUES (:code, :cat, :qid, :valid)
            ON DUPLICATE KEY UPDATE valid=VALUES(valid)";
        $stmnt = $this->db->prepare($query);

        foreach($data as $req){
            $stmnt->bindParam(':code', $req['code'], \PDO::PARAM_STR);
            $stmnt->bindParam(':cat', $req['category'], \PDO::PARAM_STR);
            $stmnt->bindParam(':qid', $req['qualifier'], \PDO::PARAM_INT);
            $valid = json_encode($req['valid']);
            $stmnt->bindParam(':valid', $valid, \PDO::PARAM_STR);
            $stmnt->execute();
        }

        return $this->db->lastInsertId();
    }

    function delete($code){
        $query = "DELETE FROM `scholarship_requirements`
                    WHERE sch_code = :code";
        $stmnt = $this->db->prepare($query);
        $stmnt->bindParam(':code', $code, \PDO::PARAM_STR);
        return $stmnt->execute();
    }
}
