<?php
namespace ScholarshipApi\Model\Scholarship;

class OfflineScholarship extends Scholarship{
    function __construct($code, $name, $description, $active, $internal, $url, $deadline = Null){
        parent::__construct($code, $name, $description, $active);
        $this->setUrl($url);
        $this->setDeadline($deadline);
        $this->setCategoryByInternal($internal);
    }

    function setCategoryByInternal($internal){
        $this->category = $internal ? self::INTERNAL : self::EXTERNAL;
    }

    function isInternal(){
        return $this->category == self::INTERNAL;
    }
}
