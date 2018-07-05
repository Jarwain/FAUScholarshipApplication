<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

class QualifierController {
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
        $id = $args['id'] ?? NULL;

        $qualifiers = $this->container->get('QualifierStore');

        if(is_null($id)){
            $msg = "Get All Qualifiers";
            $data = $qualifiers->getAll();
        } else {
            $msg = "Get Qualifier $id";
            $data = $qualifiers->get($id);
        }

        $this->container->logger->debug($msg);
        return $response->withJson($data);
    }
}
