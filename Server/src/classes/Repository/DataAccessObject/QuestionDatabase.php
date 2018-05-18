<?php
namespace ScholarshipApi\Repository\DataAccessObject;

class QuestionDatabase extends AbstractDatabase {
    public function getAll(){
        $query = "SELECT id, name, form, question, param, regex
                    FROM `qualifier`";
        $result = $this->db->query($query)->fetchAll();
        
        return $result;
    }

    public function get($id){
        $query = "SELECT id, name, form, question, param, regex
                    FROM `qualifier` 
                    WHERE id = :id";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        return $result;
    } 
}