<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

use ScholarshipApi\Service\ScholarshipService;

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
        $core = isset($query['core']) ? (bool)$query['core'] : FALSE; 

        $scholarshipService = new ScholarshipService($this->container->db);

        if(is_null($code)){
            $msg = "Get All Scholarships ";
            $msg .= is_null($online)   ? '' : "Online: $online ";
            $data = $scholarshipService->getAllScholarships($core, $online);
        } else {
            $msg = "Get Scholarship $code";
            $data = $scholarshipService->getScholarship($code);
        }

        $this->container->logger->debug($msg);
        return $response->withJson($data);
    }

    public function getRequirements(Request $request, Response $response, $args){
        $query = $request->getQueryParams();
        $code = $args['code'] ?? NULL;

        $scholarshipService = new ScholarshipService($this->container->db);

        $msg = "Get Scholarship Requirements for";
        $msg .= is_null($code)   ? 'All' : "$code";
        $data = $scholarshipService->getRequirements($code);

        $this->container->logger->debug($msg);
        return $response->withJson($data);
    }
}