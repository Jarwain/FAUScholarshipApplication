<?php
namespace ScholarshipApi\Model\Scholarship;

use ScholarshipApi\Model\Requirement\RequirementStore;
use ScholarshipApi\Model\ScholarshipQuestion\ScholarshipQuestionStore;

class OnlineScholarshipDatabase implements ScholarshipStore{
    var $db;
    var $factory;
    var $requirements;
    var $questions;

    function __construct(\PDO $db, ScholarshipFactory $factory, RequirementStore $requirements, ScholarshipQuestionStore $questions){
        $this->db = $db;
        $this->factory = $factory;
        $this->requirements = $requirements;
        $this->questions = $questions;
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

        if(is_null($result)){
            throw new \OutOfBoundsException ("Scholarship '$code' doesn't exist.");
        }

        return $this->factory->initialize('online', $result);
    }

    public function create($sch){
        try{
            $this->db->beginTransaction();

            $query = "INSERT INTO `online_scholarship` (`code`,`name`,`description`,`active`,`max`)
                VALUES (:code, :name, :description, :active, :max)";
            $stmnt = $this->db->prepare($query);

            $stmnt->bindParam(':code', $sch['code'], \PDO::PARAM_STR);
            $stmnt->bindParam(':name', $sch['name'], \PDO::PARAM_STR);
            $stmnt->bindParam(':description', $sch['description'], \PDO::PARAM_STR);
            $stmnt->bindParam(':active', $sch['active'], \PDO::PARAM_INT);
            $stmnt->bindParam(':max', $sch['max'], \PDO::PARAM_INT);
            $stmnt->execute();

            $this->requirements->bind($sch['code'], $sch['requirements']);
            $this->questions->bind($sch['code'], $sch['questions']);

            $this->db->commit();
        } catch(Exception $ex){
            $this->db->rollBack();
            throw $ex;
        }

        return $sch['code'];
    } 
}
