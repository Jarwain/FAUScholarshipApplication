<?php
namespace ScholarshipApi\Model\Scholarship;

use ScholarshipApi\Model\Requirement\RequirementStore;
use ScholarshipApi\Model\ScholarshipQuestion\ScholarshipQuestionStore;

class ScholarshipDatabase implements ScholarshipStore{
    var $db;
    var $factory;
    var $requirements;
    var $questions;

    var $online;
    var $offline;

    function __construct(\PDO $db, ScholarshipFactory $factory, RequirementStore $requirements, ScholarshipQuestionStore $questions){
        $this->db = $db;
        $this->factory = $factory;

        $this->requirements = $requirements;
        $this->questions = $questions;

        $this->online = new OnlineScholarshipDatabase($this->db, $this->factory);
        $this->offline = new OfflineScholarshipDatabase($this->db, $this->factory);
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
            throw new \OutOfBoundsException ("Scholarship doesn't exist.");
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

    /*function create($data){
        if(!is_null($this->isOnline($data['code']))){
            throw new \UnexpectedValueException("Scholarship already exists with given code.");
        }

        try{
            $db->beginTransaction();
            $scholarship = $data['category'] == 1 ? 
                $this->createOnline($data) :
                $this->createOffline($data);
        } catch(\PDOException $ex) {
            $db->rollBack();
            throw $ex;
        }
        $db->commit();
        return $scholarship;
    }

    function createOffline($data){
        $data['internal'] = $data['category'] ==function create($code, $data); 2 ? 1 : 0;
        $code = $this->offline->create($data);
        return $this->getOffline($code);
    }

    function createOnline($data){
        $code = $this->online->create($data);
        foreach($data['requirements'] as $category => $requirements){
            foreach($requirements as $qualifierId => $requirement){
                $this->requirements->create($code, $requirement);
            }
        }
        foreach(array_values($data['questions']) as $questionId){
            $this->questions->saveQuestionToScholarship($code, $questionId);
        }
        return $this->getOnline($code);
    }*/
}
