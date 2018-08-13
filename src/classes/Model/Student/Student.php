<?php
namespace ScholarshipApi\Model\Student;

class Student {
    var $znumber;
    var $first_name;
    var $last_name;
    var $email;

    var $qualifications = [];

    function __construct($znumber, $first_name, $last_name, $email){
        $this->znumber = $znumber;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
    }

    function addQualification($qualifierId, $value){
        $this->qualifications[$qualifierId] = $value;
    }

}
