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
            $res = $res->withRedirect($uri, 403);
        }
        return $res;
    }); 
});

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
})->add(function($req, $res, $next) {
    $response = $next($req, $res);
    // TODO: Reevaluate whether we reeally want this
    return $response->withAddedHeader('Access-Control-Allow-Origin', '*');
});
