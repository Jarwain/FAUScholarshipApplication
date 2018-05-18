<?php
namespace ScholarshipApi\Entity;

abstract class AbstractScholarship{
    var $code;
    var $name;
    var $description;
    var $active;

    /*
    1 - Online/Applicable
    2 - Offline Internal
    3 - Offline External
     */
    var $category;

    function __construct($code, $name, $description, $active, $category){
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->active = (int) $active;

        $this->category = (int) $category;
    }

    abstract static function Factory(array $data);

    static function BulkFactory(array $data){
        $scholarships = [];
        foreach($data as $s){
            $scholarships[$s['code']] = static::Factory($s);
        }
        return $scholarships;
    }
}