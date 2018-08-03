<?php
namespace ScholarshipApi\Model\Student;

class Student {
    var $znumber;
    var $name;
    var $email;

    var $qualifications = [];

    function __construct($znumber, $name, $email){
        $this->znumber = $znumber;
        $this->name = $name;
        $this->email = $email;
    }

    function addQualification($qualifierId, $value){

    }

    static  function renderInput(){
        return <<<START
START;
    }
}