<?php
namespace ScholarshipApi\Entity;

class OfflineScholarship extends AbstractScholarship{
    var $url;
    var $deadline;

    function __construct($code, $name, $description, $active, $internal, $url, $deadline){
        $category = $internal ? 2 : 3;
        parent::__construct($code, $name, $description, $active, $category);

        $this->url = $url;
        $this->deadline = $deadline;
    }

    static function Factory(array $data){
        return new OfflineScholarship($data['code'], $data['name'], $data['description'], $data['active'], $data['internal'], $data['url'], $data['deadline']);
    }

    function isInternal(){
        return $this->category == 2 ? 1 : 0;
    }
}