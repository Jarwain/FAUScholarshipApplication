<?php
namespace ScholarshipApi\Model\Scholarship;

class OnlineScholarshipDatabase{
    var $db;

    function __construct(\PDO $db){
        $this->db = $db;
    }

    function getAll(){
        $query = "SELECT s.code, s.name, s.description, s.active, s.max, 1 as category
                    FROM `online_scholarship` s";
        $result = $this->db->query($query)->fetchAll();

        return $result;
    }

    function get($code){
        $query = "SELECT s.code, s.name, s.description, s.active, s.max, 1 as category 
                    FROM `online_scholarship` s 
                    WHERE s.code = :code";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':code', $code, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        return $result;
    } 
}