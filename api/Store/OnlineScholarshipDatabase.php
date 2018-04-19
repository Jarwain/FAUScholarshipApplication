<?php
namespace FAUScholarship\API\Store;

use FAUScholarship\API\Model\{  OnlineScholarship, 
                                Requirement
                            };

class OnlineScholarshipDatabase implements ScholarshipInterface {
    var $db;
    const SELECT_SCHOLARSHIP =  "SELECT s.code, s.name, s.description, s.active, s.counter, s.max FROM `online_scholarship` s";
    const SELECT_REQUIREMENTS = "SELECT r.sch_code, r.category, r.qualifier, q.name, q.form, q.question, q.regex, q.param, r.valid 
                                    FROM `scholarship_requirements` r 
                                    LEFT JOIN `qualifier` q ON q.`id` = r.`qualifier`";
    const WHERE_code = "";

    function __construct($db){
        $this->db = $db;
    }

    public function listScholarships(){
        $query = self::SELECT_SCHOLARSHIP;
        $row = $this->db->query($query)->fetchAll();

        $scholarships = [];
        foreach($row as $sch){
            $scholarships[$sch['code']] = new OnlineScholarship($sch['code'], $sch['name'], $sch['description'], $sch['active'], $sch['counter'], $sch['max']);
        }

        return $scholarships;
    }

    public function getScholarships(){
        $query = self::SELECT_FULL_SCHOLARSHIP.self::JOIN_REQUIREMENTS;
        $row = $this->db->query($query)->fetchAll();

        $scholarships = [];
        foreach($row as $sch){
            $requirement = $sch['category'] !== null 
                ? new Requirement( (int)$sch['qualifier'], $sch['q_name'], $sch['form'], $sch['question'], json_decode($sch['param'], true), $sch['regex'], $sch['category'], json_decode($sch['valid'], true) )
                : NULL;

            if(!array_key_exists($sch['code'], $scholarships)){
                $scholarships[$sch['code']] = new OnlineScholarship($sch['code'], $sch['name'], $sch['description'], $sch['active'], $sch['counter'], $sch['max']);
            }
            $scholarships[$sch['code']]->addRequirement($requirement);
        }

        return $scholarships;
    }

    public function getScholarship($code){
        $query = self::SELECT_FULL_SCHOLARSHIP." WHERE s.code = :code";
        $state = $this->db->prepare($query);

        $state->bindParam(':code', $code, \PDO::PARAM_STR);
        $state->execute();
        $row = $state->fetchAll();

        $scholarship = new OnlineScholarship($row[0]['code'], $row[0]['name'], $row[0]['description'], $row[0]['active'], $row[0]['counter'], $row[0]['max']);
        foreach($row as $req){
            $requirement = $req['category'] !== null 
                ? new Requirement( (int)$req['qualifier'], $req['q_name'], $req['form'], $req['question'], json_decode($req['param'], true), $req['regex'], $req['category'], json_decode($req['valid'], true) )
                : NULL;
            $scholarship->addRequirement($requirement);
        }

        return $scholarship;
    } 
    public function createScholarship($scholarship){
        
    }
    // public function createScholarships(array $scholarships);
    // public function updateScholarship($scholarship);
    // public function updateScholarships(array $scholarships);
    // public function toggleScholarshipActive();
}