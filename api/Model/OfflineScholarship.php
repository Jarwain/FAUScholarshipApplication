<?php
namespace FAUScholarship\API\Model;

class OfflineScholarship extends AbstractScholarship{
    var $url;
    var $deadline;

    function __construct($code, $name, $description, $active, $category, $url, $deadline){
        parent::__construct($code, $name, $description, $active);
        
        $this->category = $category;
        $this->url = $url;
        $this->deadline = $deadline;

    }

    function isInternal(){
        return $this->category == 2 ? 1 : 0;
    }

    static function Internalized($code, $name, $description, $active, $internal, $url, $deadline){
        $category = $internal ? 2 : 3;
        return new OfflineScholarship($code, $name, $description, $active, $category, $url, $deadline);
    }
}