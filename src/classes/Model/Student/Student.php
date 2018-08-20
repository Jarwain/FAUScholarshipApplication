<?php
namespace ScholarshipApi\Model\Student;

use ScholarshipApi\Util\ValidationException;

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

    static function DataMap($data) {
        $error = [];
        foreach($data as $key => $val){
            if(empty($val)){
                $error[] = "Student missing $key";
            }
        }
        if(!empty($error)){
            throw new ValidationException("Student Info Error", $error);
        }
        $student = new Student($data['znumber'], $data['first_name'], 
            $data['last_name'], $data['email']);

        return $student;
    }

    function addQualification($qualifierId, $value){
        $this->qualifications[$qualifierId] = $value;
    }

}
