<?php
namespace ScholarshipApi\Entity;

use ScholarshipApi\Entity\Qualifier;

class Student{
    var $znumber;
    var $name;
    var $email;

    // TODO: (maybe)Refactor so that there's $pass and $fail

    function __construct($znumber, $name, $email){
        $this->znumber = $znumber;
        $this->name = $name;
        $this->email = $email;
    }

    static function Factory(array $data){
        return new Requirement($data['id'] ?? NULL, $data['qualifier'], $data['valid']);
    }
}