<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require 'settings.php';

$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();
require 'container.php';

$app->add(function($req, $res, $next) {
    $response = $next($req, $res);

    return $response->withAddedHeader('Access-Control-Allow-Origin', '*');
});

$app->group('/scholarships', function() use ($app){

    $app->get('/', function (Request $request, Response $response) {
        $this->logger->debug("GET /scholarships/");

        $params = $request->getQueryParams();
        if(array_key_exists('full', $params)){
            if($params['full'] == 'true'){
            }
        } else {
            $data = $this->sch->getScholarships(true);
        }
        return $response->withJson($data);
    });

    $app->post('/', function (Request $request, Response $response){
        $this->logger->debug("POST /scholarships/");

        $parsedBody = $request->getParsedBody();
        $this->logger->debug(json_encode($parsedBody));
        try{
            $this->sch->addScholarship($parsedBody);
            $data = ['success'];
        } catch(Exception $e) {
            $this->logger->error($e->getMessage());
            $data = ['error' => $e->getMessage()];
        }

        return $response->withJson($data);
    });

    $app->put('/', function (Request $request, Response $response){

    });


    $app->group('/{id}', function () {
        $this->map(['GET', 'POST', 'PUT'], '', function(Request $request, Response $response, $args){
            if($request->isGet()){
                if(!empty($args)){ 
                // Scholarship Code Given

                } else {
                    $this->getAllScholarshipInfo();
                }
            } else if($request->isPost()){

            } else if($request->isPut()){

            }
        $data = json_decode(file_get_contents("../assets/scholarship.json"));

        return $response->withJson($data);
        });
    });
});

$app->run();