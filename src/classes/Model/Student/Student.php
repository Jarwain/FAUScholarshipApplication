<?php
namespace ScholarshipApi\Model\Student;

class Student {
    var $znumber;
    var $first_name;
    var $last_name;
    var $email;
    var $videoAuth;

    var $qualifications = [];

    function __construct($znumber, $first_name, $last_name, $email, $videoAuth = null){
        $this->znumber = $znumber;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;

        $this->videoAuth = $videoAuth;
    }

    static function DataMap($data) {
        $student = new Student($data['znumber'], $data['first_name'], 
            $data['last_name'], $data['email'], $data['videoAuth'] ?? NULL);
        return $student;
    }

    function addQualification($qualifier, $value){
        $this->qualifications[$qualifier] = $value;
    }

}
