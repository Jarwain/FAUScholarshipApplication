<?php
namespace FAUScholarship\API\Model;

abstract class AbstractScholarship {
    var $code;
    var $name;
    var $description;
    var $active;

    var $category;

    function __construct($code, $name, $description, $active){
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->active = $active;
    }
}
