<?php
namespace ScholarshipApi\Model\Scholarship;

use ScholarshipApi\Model\Requirement\RequirementStore;
use ScholarshipApi\Model\ScholarshipQuestion\ScholarshipQuestionStore;

class ScholarshipDatabase implements ScholarshipStore{
    var $db;

    var $online;
    var $offline;

    function __construct(\PDO $db, RequirementStore $requirements, ScholarshipQuestionStore $questions){
        $this->db = $db;

        $factory = new ScholarshipFactory($requirements, $questions);

        $this->online = new OnlineScholarshipDatabase($this->db, $factory, $requirements, $questions);
        $this->offline = new OfflineScholarshipDatabase($this->db, $factory);
    }

    /**
     * checks if scholarship exists
     * @param  String $code Scholarship Code
     * @return Bool/Null       Null if not exist, True/False for Online/Offline. 
     */
    private function isOnline($code){
        $query = "  SELECT `code`, 1 as isOnline FROM `online_scholarship` WHERE `code` = :code
                    UNION
                    SELECT `code`, 0 from `offline_scholarship` WHERE `code` = :code";
        $state = $this->db->prepare($query);
        $state->bindParam(':code', $code, \PDO::PARAM_STR);
        $state->execute();
        $result = $state->fetch()['isOnline'];
        
        return $result;
    }

    function get($code){
        $isOnline = $this->isOnline($code);
        
        if(is_null($isOnline)){
            throw new \OutOfBoundsException ("Scholarship '$code' doesn't exist.");
        } else {
            return  $isOnline ? 
                $this->online->get($code) :
                $this->offline->get($code);
        }
    }

    function getOnline(){
        return $this->online->getAll();
    }

    function getOffline(){
        return $this->offline->getAll();
    }

    function getAll(){
        return $this->getOffline() + $this->getOnline();
    }

    /**
     * Create/Save Scholarship
     * @param  array $data Scholarship Data
     * @return String       Scholarship Code
     */
    function create($data){
        switch($data['category']){
            case 1:
                return $this->online->create($data);
                break;
            case 2:
            case 3:
                return $this->offline->create($data);
                break;
            default:
                throw new \LogicException("Invalid Category");
        }
    }
}
