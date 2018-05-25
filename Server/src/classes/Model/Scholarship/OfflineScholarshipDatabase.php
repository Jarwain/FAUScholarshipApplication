<?php
namespace ScholarshipApi\Model\Scholarship;

class OfflineScholarshipDatabase{
    var $db;

    function __construct(\PDO $db, ScholarshipFactory $factory){
        $this->db = $db;
        $this->factory = $factory;
    }    

    function getAll(){
        $query = "SELECT s.code, s.name, s.description, s.active, s.internal, s.url, s.deadline 
                    FROM `offline_scholarship` s";
        $result = $this->db->query($query)->fetchAll();

        return $this->factory->bulkInitialize('offline', $result);
    }

    function get($code){
        $query = "SELECT s.code, s.name, s.description, s.active, s.internal, s.url, s.deadline 
                    FROM `offline_scholarship` s 
                    WHERE s.code = :code";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':code', $code, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        return $this->factory->initialize('offline', $result);
    } 
    
    /*public function save($sch){
        $query = "INSERT INTO `offline_scholarship` (`name`,`description`,`active`,`internal`,`url`,`deadline`)
            VALUES (:name, :descript, :active, :internal, :url, :deadline)";
        $state = $this->db->prepare($query);
        $internal = $sch->isInternal();

        $state->bindParam(':name', $sch->name, \PDO::PARAM_STR);
        $state->bindParam(':descript', $sch->description, \PDO::PARAM_STR);
        $state->bindParam(':active', $sch->active, \PDO::PARAM_INT);
        $state->bindParam(':internal', $internal, \PDO::PARAM_INT);
        $state->bindParam(':url', $sch->url, \PDO::PARAM_STR);
        $state->bindParam(':deadline', $sch->deadline, \PDO::PARAM_STR);
        $state->execute();
    }*/
}