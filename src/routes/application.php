<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/application', function() use ($app){
    $app->map(['GET','POST'], '/', 'ScholarshipApi\Controller\ApplicationController:studentForm');
    $app->map(['GET','POST'], '/select/', 'ScholarshipApi\Controller\ApplicationController:scholarshipSelect');
    $app->get('/test/', 'ScholarshipApi\Controller\ApplicationController:test');
});
