<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/search', function() use ($app){
    $app->get(  '/','ScholarshipApi\Controller\SearchController:index');
    $app->post( '/','ScholarshipApi\Controller\SearchController:search');
});
