<?php

// TODO: If a separate cache is desired, create a ScholarshipRepository class using the interface, have the cache use the interface, have the ScholarshipRepository decide whether to pull from the cache or from the database. 
// Or do it some other way -shrugs-
$container['ScholarshipStore'] = function ($c) {
    try {
        $factory = new ScholarshipApi\Model\Scholarship\ScholarshipFactory();
        $database = new ScholarshipApi\Model\Scholarship\ScholarshipDatabase($c->db, $factory);

        $repo = new ScholarshipApi\Model\Scholarship\ScholarshipRepository($database);

        return $repo;
    } catch (\Exception $ex){
        $c->logger->addError($ex);
    }
};

/*$container['QualifierStore'] = function ($c) {
    try {

    } catch (\Exception $ex) {
        $c->logger->addError($ex);
    }
};*/