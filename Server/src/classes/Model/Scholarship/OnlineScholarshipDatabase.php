<?php
namespace ScholarshipApi\Model\Scholarship;

class OnlineScholarshipDatabase{
    var $db;

    function __construct(\PDO $db, ScholarshipFactory $factory){
        $this->db = $db;
        $this->factory = $factory;
    }

    function getAll(){
        $query = "SELECT s.code, s.name, s.description, s.active, s.max
                    FROM `online_scholarship` s";
        $result = $this->db->query($query)->fetchAll();

        return $this->factory->bulkInitialize('online', $result);
    }

    function get($code){
        $query = "SELECT s.code, s.name, s.description, s.active, s.max
                    FROM `online_scholarship` s 
                    WHERE s.code = :code";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':code', $code, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        return $this->factory->initialize('online', $result);
    }

    public function create($sch){
        $query = "INSERT INTO `online_scholarship` (`code`,`name`,`description`,`active`,`max`)
            VALUES (:code, :name, :description, :active, :max)";
        $state = $this->db->prepare($query);

        $state->bindParam(':code', $sch['code'], \PDO::PARAM_STR);
        $state->bindParam(':name', $sch['name'], \PDO::PARAM_STR);
        $state->bindParam(':description', $sch['description'], \PDO::PARAM_STR);
        $state->bindParam(':active', $sch['active'], \PDO::PARAM_INT);
        $state->bindParam(':max', $sch['max'], \PDO::PARAM_INT);
        $state->execute();

        return $sch['code'];
    } 
}
