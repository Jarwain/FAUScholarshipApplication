<?php
namespace FAUScholarship\API;

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
    /*
    $datastore = new Store($container);
    $controller = new Controller($model); $controller->action() {$model->mutate()}
    $view = new View($model);

    Route calls $controller->action(). This calls $datastore->get/set(). 
    still figuring out what $view will do
     */


    $app->get('/[{code}/]', function (Request $request, Response $response, $args) {
        if(isset($args['code'])){
            $this->logger->debug("GET /scholarships/".$args['code']);
            $data = $this->scholarshipStore->getScholarship($args['code']);
        } else {
            $this->logger->debug("GET /scholarships/");
            $data = $this->scholarshipStore->getScholarships();
        }
        return $response->withJson($data);
    });
    $app->post('/', function (Request $request, Response $response){
        $body = $request->getParsedBody();

        $this->logger->debug("POST /scholarships/ Body: {${json_encode($body)}}");

        try{
            $this->scholarshipStore->createScholarship($body);
            $data = ['success'];
        } catch(Exception $e) {
            $this->logger->error($e->getMessage());
            $data = ['error' => $e->getMessage()];
        }

        return $response->withJson($data);
    });

    /*$app->put('/', function (Request $request, Response $response){

    });*/


    /*$app->group('/{code}', function () {
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
    });*/
});

$app->run();