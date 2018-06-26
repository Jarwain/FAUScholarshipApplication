<?php

// TODO: If a separate cache is desired, create a ScholarshipRepository class using the interface, have the cache use the interface, have the ScholarshipRepository decide whether to pull from the cache or from the database. 
// TODO: Meta-program/figure out how to just pass the class names to get the dependencies

$container['QuestionStore'] = function ($c) {
    try {
        $factory = new ScholarshipApi\Model\Question\QuestionFactory();
        $database = new ScholarshipApi\Model\Question\QuestionDatabase($c->get('db'), $factory);

        $repo = new ScholarshipApi\Model\Question\QuestionRepository($database);
        return $repo;
    } catch (\Exception $ex) {
        $c->get('logger')->addError($ex);
    }
};

$container['QualifierStore'] = function ($c) {
    try {
        $factory = new ScholarshipApi\Model\Qualifier\QualifierFactory();
        $database = new ScholarshipApi\Model\Qualifier\QualifierDatabase($c->get('db'), $factory);

        $repo = new ScholarshipApi\Model\Qualifier\QualifierRepository($database);
        return $repo;
    } catch (\Exception $ex) {
        $c->get('logger')->addError($ex);
    }
};

$container['RequirementStore'] = function ($c) {
    try {
        $qualifiers = $c->get('QualifierStore');
        $qualifiers->getAll(); // Initialize Qualifiers!
        $factory = new ScholarshipApi\Model\Requirement\RequirementFactory($qualifiers);
        $database = new ScholarshipApi\Model\Requirement\RequirementDatabase($c->get('db'), $factory);

        $repo = new ScholarshipApi\Model\Requirement\RequirementRepository($database);
        return $repo;
    } catch (\Exception $ex) {
        $c->get('logger')->addError($ex);
    }
};

$container['ScholarshipStore'] = function ($c) {
    try {
        $requirements = $c->get('RequirementStore');
        $requirements->getAll();
        $questions = $c->get('QuestionStore');
        $questions->getAllByScholarship();
        
        $factory = new ScholarshipApi\Model\Scholarship\ScholarshipFactory($requirements, $questions);
        $database = new ScholarshipApi\Model\Scholarship\ScholarshipDatabase($c->get('db'), $factory, $requirements, $questions);

        $repo = new ScholarshipApi\Model\Scholarship\ScholarshipRepository($database);

        return $repo;
    } catch (\Exception $ex){
        $c->get('logger')->addError($ex);
    }
};
