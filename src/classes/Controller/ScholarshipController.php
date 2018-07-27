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
        $scholarships = $this->container->get('ScholarshipStore');
        $code = $args['code'] ?? NULL;

        if(is_null($code)){
            $msg = "Get All Scholarships";
            $data = $scholarships->getAll();
        } else {
            $msg = "Get Scholarship $code";
            $data = $scholarships->get($code);
        }

        $this->container->logger->debug($msg);
        return $response->withJson($data);
    }

    public function save(Request $request, Response $response, $args){
        $scholarships = $this->container->get('ScholarshipStore');
        $body = $request->getParsedBody();
        $code = $args['code'] ?? NULL;

        $msg = "Save Scholarship " . json_encode($body);
        $data = $scholarships->save($body);

        $this->container->logger->debug($msg);
        return $response->withJson($data);
    }

    public function delete(Request $request, Response $response, $args){
        // TODO: Don't actually delete the scholarship!!!
        // Create a `deleted` column, with deletion timestamp
        $code = $args['code'] ?? NULL;
        if(is_null($code)){

        }
    }
}
