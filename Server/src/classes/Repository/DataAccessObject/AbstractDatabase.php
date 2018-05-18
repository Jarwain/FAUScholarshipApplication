<?php
namespace ScholarshipApi\Repository\DataAccessObject;

abstract class AbstractDatabase{
    var $db;

    function __construct(\PDO $db){
        $this->db = $db;
    }
}