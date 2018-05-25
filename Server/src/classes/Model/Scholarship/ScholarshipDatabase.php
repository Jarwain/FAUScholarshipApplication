<?php
namespace ScholarshipApi\Model\Scholarship;

class ScholarshipDatabase implements ScholarshipStore{
    var $db;
    var $factory;

    var $online;
    var $offline;

    function __construct(\PDO $db, ScholarshipFactory $factory){
        $this->db = $db;
        $this->factory = $factory;

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

    function get($code){
        if($this->isOnline($code)){
            $type = 'online';
            $scholarship = $this->online->get($code);
        } else {
            $type = 'offline';
            $scholarship = $this->offline->get($code);
        }

        return $this->factory->initialize($type, $scholarship);
    }

    function getOnline(){
        return $this->factory->bulkInitialize('online', $this->online->getAll());
    }

    function getOffline(){
        return $this->factory->bulkInitialize('offline', $this->offline->getAll());
    }

    function getAll(){
        return $this->getOffline() + $this->getOnline();
    }
}