<?php

// TODO: If a separate cache is desired, create a ScholarshipRepository class using the interface, have the cache use the interface, have the ScholarshipRepository decide whether to pull from the cache or from the database. 
// TODO: Meta-program/figure out how to just pass the class names to get the dependencies

$container['authenticator'] = function($c) {
    try {
        $users = new ScholarshipApi\Model\User\UserDatabase($c->get('db'));
        $auth = new ScholarshipApi\Service\Authentication($users, $c->get('session'), $c->get('logger'));
        return $auth;
    } catch(\Exception $ex) {
        $c->get('logger')->addError($ex);
    }
};

$container['SearchService'] = function($c) {
    $qualifiers = $c->get('QualifierStore');
    $applications = $c->get('ApplicationStore');
    return new ScholarshipApi\Service\SearchService($qualifiers, $applications);
};

$container['ApplicationStore'] = function ($c) {
    try {
        $database = new ScholarshipApi\Model\Application\ApplicationDatabase($c->get('db'));
        $repo = new ScholarshipApi\Model\Application\ApplicationRepository($database);
        return $repo;
    } catch (\Exception $ex) {
        $c->get('logger')->addError($ex);
    }
};

$container['FileStore'] = function ($c) {
    try {
        $database = new ScholarshipApi\Model\File\FileDatabase($c->get('db'));
        $repo = new ScholarshipApi\Model\File\FileRepository($database);
        return $repo;
    } catch (\Exception $ex) {
        $c->get('logger')->addError($ex);
    }
};

$container['StudentStore'] = function ($c) {
    try {
        $database = new ScholarshipApi\Model\Student\StudentDatabase($c->get('db'));
        $repo = new ScholarshipApi\Model\Student\StudentRepository($database);
        return $repo;
    } catch (\Exception $ex) {
        $c->get('logger')->addError($ex);
    }
};

$container['QuestionStore'] = function ($c) {
    try {
        $database = new ScholarshipApi\Model\Question\QuestionDatabase($c->get('db'));
        $repo = new ScholarshipApi\Model\Question\QuestionRepository($database);
        $repo->getAll();
        return $repo;
    } catch (\Exception $ex) {
        $c->get('logger')->addError($ex);
    }
};

$container['QualifierStore'] = function ($c) {
    try {
        $database = new ScholarshipApi\Model\Qualifier\QualifierDatabase($c->get('db'));
        $repo = new ScholarshipApi\Model\Qualifier\QualifierRepository($database);
        $repo->getAll();
        return $repo;
    } catch (\Exception $ex) {
        $c->get('logger')->addError($ex);
    }
};

$container['RequirementStore'] = function ($c) {
    try {
        $qualifiers = $c->get('QualifierStore');
        $database = new ScholarshipApi\Model\Requirement\RequirementDatabase($c->get('db'), $qualifiers);
        $repo = new ScholarshipApi\Model\Requirement\RequirementRepository($database);
        return $repo;
    } catch (\Exception $ex) {
        $c->get('logger')->addError($ex);
    }
};

$container['ScholarshipQuestionStore'] = function ($c) {
    try {
        $questions = $c->get('QuestionStore');
        $database = new ScholarshipApi\Model\ScholarshipQuestion\ScholarshipQuestionDatabase($c->get('db'), $questions);
        $repo = new ScholarshipApi\Model\ScholarshipQuestion\ScholarshipQuestionRepository($database);
        return $repo;
    } catch (\Exception $ex) {
        $c->get('logger')->addError($ex);
    }
};

$container['ScholarshipStore'] = function ($c) {
    try {
        $requirements = $c->get('RequirementStore');
        $requirements->getAll();
        $questions = $c->get('ScholarshipQuestionStore');
        $questions->getAll();
        
        $database = new ScholarshipApi\Model\Scholarship\ApplicableScholarshipDatabase($c->get('db'), $requirements, $questions);
        $repo = new ScholarshipApi\Model\Scholarship\ScholarshipRepository($database);

        return $repo;
    } catch (\Exception $ex){
        $c->get('logger')->addError($ex);
    }
};
