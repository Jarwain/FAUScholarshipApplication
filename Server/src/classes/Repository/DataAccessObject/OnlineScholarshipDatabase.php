<?php
namespace ScholarshipApi\Repository\DataAccessObject;

class OnlineScholarshipDatabase extends AbstractDatabase {
    public function getAll(){
        $query = "SELECT s.code, s.name, s.description, s.active, s.counter, s.max, 1 as category
                    FROM `online_scholarship` s";
        $result = $this->db->query($query)->fetchAll();

        return $result;
    }

    public function get($code){
        $query = "SELECT s.code, s.name, s.description, s.active, s.counter, s.max, 1 as category 
                    FROM `online_scholarship` s 
                    WHERE s.code = :code";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':code', $code, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        return $result;
    } 
}