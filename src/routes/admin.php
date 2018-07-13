<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/admin', function() use ($app){
    $app->map(['GET', 'POST'], '/login/', 'ScholarshipApi\Controller\AdminController:login')->setName('login');

    // Must be authenticated to access the group below
    $app->group('', function() use ($app){
        $app->get('/','ScholarshipApi\Controller\AdminController:home');
    })->add(function($req, $res, $next) {
        if(isset($this->session['auth']['user'])){
            // If Authenticated, do next thing
            $res = $next($req, $res);
        } else {
            $uri = $req->getUri()->getBasePath() . '/admin/login/';
            $res = $res->withRedirect($uri, 303);
        }
        return $res;
    }); 
});
