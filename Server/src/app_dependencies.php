<?php

// TODO: If a separate cache is desired, create a ScholarshipRepository class using the interface, have the cache use the interface, have the ScholarshipRepository decide whether to pull from the cache or from the database. 
// Or do it some other way -shrugs-
$container['ScholarshipStore'] = function ($c) {
    try{
        $database = new ScholarshipApi\Model\Scholarship\ScholarshipDatabase($c->get('db'));
        
        $repo = $database;
        if(!($repo instanceof ScholarshipApi\Model\Scholarship\ScholarshipStore)){
            throw new \InvalidArgumentException("Not a Scholarship Store");
        }
        return $repo;
    } catch (\Exception $ex){
        $c->logger->addError($ex);
    }
};