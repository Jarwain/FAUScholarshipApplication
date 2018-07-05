<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

class ScholarshipController {
    protected $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    /*
    Default: returns all scholarships full
    If $code is set: returns scholarship with $code. Ignore all other parameters.
    ?online: if true, return online scholarships. if false, return offline scholarships. if null, return all. 
    */
    public function get(Request $request, Response $response, $args){
        $query = $request->getQueryParams();
        $code = $args['code'] ?? NULL;
        $online = isset($query['online']) ? (bool)$query['online'] : NULL; 

        $scholarships = $this->container->get('ScholarshipStore');

        if(is_null($code)){
            if(is_null($online)){
                $msg = "Get All Scholarships";
                $data = $scholarships->getAll();
            } else {
                $msg = $online ? "Get All Scholarships Online" : "Get All Scholarships Offline";
                $data = $online ? $scholarships->getOnline() : $scholarships->getOffline();
            }
        } else {
            $msg = "Get Scholarship $code";
            $data = $scholarships->get($code);
        }

        $this->container->logger->debug($msg);
        return $response->withJson($data);
    }

    public function create(Request $request, Response $response, $args){
        $body = $request->getParsedBody();
        $scholarships = $this->container->get('ScholarshipStore');

        $msg = "Create Scholarship " . json_encode($body);
        $data = $scholarships->create($body);

        $this->container->logger->debug($msg);
        return $response->withJson($data);
    }

    public function update(Request $request, Response $response, $args){
        $code = $args['code'] ?? NULL;
        $body = $request->getParsedBody();    
    }

    public function delete(Request $request, Response $response, $args){
        $code = $args['code'] ?? NULL;
        if(is_null($code)){

        }
    }
}
