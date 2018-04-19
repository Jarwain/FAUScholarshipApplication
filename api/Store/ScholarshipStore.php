<?php
namespace FAUScholarship\API\Store;

use FAUScholarship\API\Store\{
    OnlineScholarshipDatabase,
    OfflineScholarshipDatabase
};

use FAUScholarship\API\Model\OfflineScholarship;

class ScholarshipStore implements ScholarshipInterface {
    var $container;

    var $onlineDB;
    var $offlineDB;
    // var $cache;
    
    function __construct(&$c) {
        $this->container = $c;
        $this->onlineDB = new OnlineScholarshipDatabase($c->db);
        $this->offlineDB = new OfflineScholarshipDatabase($c->db);
    }

    private function getOnlineScholarships(){
        return $this->onlineDB->getScholarships();
    }
    private function getOnlineScholarship($code){
        return $this->onlineDB->getScholarship($code);
    }

    private function getOfflineScholarships(){
        return $this->offlineDB->getScholarships();
    }
    private function getOfflineScholarship($code){
        return $this->offlineDB->getScholarship($code);
    }

    function getScholarship($code){
        switch($this->isOnline($code)){
            case 1:
                return $this->getOnlineScholarship($code);
                break;
            case 0:
                return $this->getOfflineScholarship($code);
                break;
            default:
                throw new Exception("Invalid Code");
        }
    }

    function getScholarships($onlineOnly = false){
        if($onlineOnly)
            return $this->getOnlineScholarships();
        else 
            return array_merge($this->getOnlineScholarships(), $this->getOfflineScholarships());
    }

    function createScholarship($sch){
        /*if($sch['category'] == 1)
            return $this->createOnlineScholarship($sch);
        else*/
            return $this->createOfflineScholarship($sch);
    }

    private function createOnlineScholarship($sch){

    }

    private function createOfflineScholarship($sch){
        $scholarship = new OfflineScholarship(null, $sch['name'], $sch['description'], $sch['active'], $sch['category'], $sch['url'], $sch['deadline']);
        return $this->offlineDB->createScholarship($scholarship);
    }

    private function isOnline($code){
        $query = "  SELECT `code`, 1 as isOnline FROM `online_scholarship` WHERE `code` = :code
                    UNION
                    SELECT `code`, 0 from `offline_scholarship` WHERE `code` = :code";
        $state = $this->container->db->prepare($query);
        $state->bindParam(':code', $code, \PDO::PARAM_STR);
        $state->execute();
        $row = $state->fetchAll();

        return $row[0]['isOnline'];
    }
}