<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/admin', function() use ($app){
    $app->map(['GET', 'POST'], '/login/', 'ScholarshipApi\Controller\AdminController:login')->setName('login');
    $app->get('/logout/', 'ScholarshipApi\Controller\AdminController:logout');

    // Must be authenticated to access the group below
    $app->group('', function() use ($app){
        $app->get('/','ScholarshipApi\Controller\AdminController:scholarshipView');
        $app->get('/scholarship/[{code}/]','ScholarshipApi\Controller\AdminController:scholarshipView');
        $app->get('/question/[{id}/]','ScholarshipApi\Controller\AdminController:questionView');
        $app->get('/qualifier/[{id}/]','ScholarshipApi\Controller\AdminController:qualifierView');
        $app->get('/create/[{item}/]','ScholarshipApi\Controller\AdminController:createItem');
    })->add(function($req, $res, $next) {
        if($this->authenticator->isAuthenticated()){
            // If Authenticated, do next thing
            $res = $next($req, $res);
        } else {
            $uri = $req->getUri()->getBasePath() . '/admin/login/';
            $res = $res->withRedirect($uri, 303);
        }
        return $res;
    }); 
});
