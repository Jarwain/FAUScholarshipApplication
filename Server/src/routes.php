<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/api', function() use ($app){
    $app->group('/scholarship', function() use ($app){
        $app->get(      '/[{code}/]',  'ScholarshipApi\Controller\ScholarshipController:get');
        $app->post(     '/',           'ScholarshipApi\Controller\ScholarshipController:create');
        $app->post(     '/{code}/',    'ScholarshipApi\Controller\ScholarshipController:update');
        $app->put(      '/{code}/',    'ScholarshipApi\Controller\ScholarshipController:update');
        $app->delete(   '/{code}/',    'ScholarshipApi\Controller\ScholarshipController:delete');
    });

    $app->group('/qualifier', function() use ($app){
        $app->get('/[{id}/]', 'ScholarshipApi\Controller\QualifierController:get');
    });

    $app->group('/question', function() use ($app){
        $app->get('/[{id}/]', 'ScholarshipApi\Controller\QuestionController:get');
    });
});

$app->group('/admin', function() use ($app){
});

$app->group('/application', function() use ($app){
});

$app->group('/search', function() use ($app){
});
