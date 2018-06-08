<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/scholarship', function() use ($app){
    $app->get('/[{code}/]', 'ScholarshipApi\Controller\ScholarshipController:get');
});

$app->group('/qualifier', function() use ($app){
    $app->get('/[{id}/]', 'ScholarshipApi\Controller\QualifierController:get');
});

$app->group('/question', function() use ($app){
    $app->get('/[{id}/]', 'ScholarshipApi\Controller\QuestionController:get');
});



/*
 * Search Service
 */
/*$app->group('/qualifier', function() use ($app, $container){
    $app->get('/', function (Request $request, Response $response, $args) use ($controller){
        $this->logger->debug("Get all qualifiers");
        return $response->withJson($controller->getScholarships());
    });
});
$app->group('/search', function() use ($app, $container){
    
    $controller = new SearchController($container);

    $app->get('/', function (Request $request, Response $response, $args) use ($controller){
        $query = $request->getQueryParams();
        if(isset($query) && !empty($query)){
            $this->logger->debug("Search Scholarships");
            $data = $controller->searchScholarships($query);
        } else {
            $this->logger->debug("Get Qualifiers");
            $data = $controller->getQualifiers();
        }
        return $response->withJson($data);
    });
    
});
*/