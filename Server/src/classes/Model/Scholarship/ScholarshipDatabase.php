<?php
namespace ScholarshipApi\Model\Scholarship;

class ScholarshipDatabase implements ScholarshipStore{
    var $db;

    var $online;
    var $offline;

    function __construct(\PDO $db, ScholarshipFactory $factory){
        $this->db = $db;

        $this->online = new OnlineScholarshipDatabase($this->db, $factory);
        $this->offline = new OfflineScholarshipDatabase($this->db, $factory);
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

    function get($code){
        return $this->isOnline($code) ? 
            $this->online->get($code) :
            $this->offline->get($code);
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
}