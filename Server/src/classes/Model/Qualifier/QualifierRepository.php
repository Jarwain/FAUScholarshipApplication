<?php
namespace ScholarshipApi\Repository;

use ScholarshipApi\Repository\DataAccessObject\QualifierDatabase;
use ScholarshipApi\Entity\Qualifier;

class QualifierRepository{
    var $database;
    var $cache; // TODO: (low priority)

    function __construct(\PDO $db){
        $this->database = new QualifierDatabase($db);
    }

    function getAll(){
        $data = $this->database->getAll();
        $qualifiers = [];

        foreach($data as $q){
            $qualifiers[$q['id']] = Qualifier::Factory($q);
        }

        return $qualifiers;
    }

    function get($id){
        return Qualifier::Factory($this->database->get($id));
    }
}