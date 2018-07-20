<?php
namespace ScholarshipApi\Model\User;

class User {
    var $id;
    var $name;
    private $password;

    function __construct($name, $password){
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
    }

    function getName(){
        return $this->name;
    }

    function getPassword(){
        return $this->password;
    }

    function setPassword($password){
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}