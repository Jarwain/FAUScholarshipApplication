<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/application', function() use ($app){
    $app->get('/[student/]', 'ScholarshipApi\Controller\ApplicationController:studentInfo');
});
