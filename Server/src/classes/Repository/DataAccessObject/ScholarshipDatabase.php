<?php
namespace ScholarshipApi\Repository\DataAccessObject;

class ScholarshipDatabase extends AbstractDatabase {
    var $online;
    var $offline;

    function __construct(\PDO $db){
        parent::__construct($db);

        $this->online = new OnlineScholarshipDatabase($this->db);
        $this->offline = new OfflineScholarshipDatabase($this->db);
    }

    private function isOnline($code){
        $query = "  SELECT `code`, 1 as isOnline FROM `online_scholarship` WHERE `code` = :code
                    UNION
                    SELECT `code`, 0 from `offline_scholarship` WHERE `code` = :code";
        $state = $this->db->prepare($query);
        $state->bindParam(':code', $code, \PDO::PARAM_STR);
        $state->execute();
        $result = $state->fetch()['isOnline'];
        
        if(is_null($result)){
            throw new \UnexpectedValueException ("Scholarship doesn't exist.");
        }

        return $result;
    }

    // Returns [$scholarship, $isOnline]
    function get($code){
        return $this->isOnline($code) ? 
            [$this->online->get($code), true] :
            [$this->offline->get($code), false];
    }

    function getOnline(){
        return $this->online->getAll();
    }

    function getOffline(){
        return $this->offline->getAll();
    }
}