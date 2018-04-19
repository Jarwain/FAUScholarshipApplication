<?php
namespace FAUScholarship\API\Store;

use FAUScholarship\API\Model\OfflineScholarship;

class OfflineScholarshipDatabase implements ScholarshipInterface {
    var $db;
    const SELECT_SCHOLARSHIP = "SELECT s.code, s.name, s.description, s.active, s.internal, s.url, s.deadline FROM `offline_scholarship` s";
    const WHERE_code = " WHERE s.code = :code";

    function __construct($db){
        $this->db = $db;
    }

    public function getScholarships(){
        $query = self::SELECT_SCHOLARSHIP;
        $row = $this->db->query($query)->fetchAll();

        $scholarships = [];
        foreach($row as $sch){
            $scholarships[$sch['code']] = OfflineScholarship::Internalized($sch['code'], $sch['name'], $sch['description'], $sch['active'], $sch['internal'], $sch['url'], $sch['deadline']);
        }

        return $scholarships;
    }

    public function getScholarship($code){
        $query = self::SELECT_SCHOLARSHIP.self::WHERE_code;
        $state = $this->db->prepare($query);
        $state->bindParam(':code', $code, \PDO::PARAM_STR);
        $state->execute();
        $row = $state->fetchAll();

        $scholarship = OfflineScholarship::Internalized($row[0]['code'], $row[0]['name'], $row[0]['description'], $row[0]['active'], $row[0]['internal'], $row[0]['url'], $row[0]['deadline']);

        return $scholarship;
    } 
    
    public function createScholarship($sch){
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
    }
    // public function createScholarships(array $scholarships);
    // public function updateScholarship($scholarship);
    // public function updateScholarships(array $scholarships);
    // public function toggleScholarshipActive();
}