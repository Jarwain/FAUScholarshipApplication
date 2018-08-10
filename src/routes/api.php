<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/api', function() use ($app){
    $app->group('/student', function() use ($app){
        // $app->get(      '/[{znumber}/]',  'ScholarshipApi\Controller\ScholarshipController:get');
        // $app->post(     '/',  'ScholarshipApi\Controller\StudentController:save');
    });

    $app->group('/application', function() use ($app){
        // $app->get(      '/[{code}/]',  'ScholarshipApi\Controller\ScholarshipController:get');
        // $app->post(     '/',  'ScholarshipApi\Controller\ApplicationController:save');
    });

    $app->group('/scholarship', function() use ($app){
        $app->get(      '/[{code}/]',  'ScholarshipApi\Controller\ScholarshipController:get');
        $app->post(     '/[{code}/]',  'ScholarshipApi\Controller\ScholarshipController:save');
        $app->delete(   '/{code}/',    'ScholarshipApi\Controller\ScholarshipController:delete');
    });

    $app->group('/qualifier', function() use ($app){
        $app->get('/[{id}/]', 'ScholarshipApi\Controller\QualifierController:get');
    });

    $app->group('/question', function() use ($app){
        $app->get('/[{id}/]', 'ScholarshipApi\Controller\QuestionController:get');
    });
})->add(function($req, $res, $next) {
    $response = $next($req, $res);
    // TODO: Reevaluate whether we reeally need this
    return $response->withAddedHeader('Access-Control-Allow-Origin', '*');
});
