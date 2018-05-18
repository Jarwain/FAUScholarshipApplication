<?php
namespace ScholarshipApi\Repository\DataAccessObject;

class RequirementDatabase extends AbstractDatabase implements Crud {
    public function getAllTest(){
        $query = "SELECT sch_code, id, category, qualifier_id, valid
                    FROM `scholarship_requirements`";
        $result = $this->db->query($query)->fetchAll(\PDO::FETCH_GROUP);

        return $result;
    }

    public function getAll(){
        $query = "SELECT id, sch_code, category, qualifier_id, valid
                    FROM `scholarship_requirements`";
        $result = $this->db->query($query)->fetchAll();

        return $result;
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

        $stmnt->bindParam(':code', $code, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetchAll();

        return $result;
    } 
}