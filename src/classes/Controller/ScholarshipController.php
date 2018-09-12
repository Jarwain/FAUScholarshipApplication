<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

class ScholarshipController extends AbstractController{
    /*
    Default: returns all scholarships full
    If $code is set: returns scholarship with $code. Ignore all other parameters.
    ?active: if true, return all active scholarships
    ?online: if true, return online scholarships. if false, return offline scholarships. if null, return all. 
    */
    public function get(Request $request, Response $response, $args){
        $scholarships = $this->container->get('ScholarshipStore');
        $code = $args['code'] ?? NULL;

        if(is_null($code)){
            $active = $request->getQueryParam('active');
            $search = $request->getQueryParam('search');
            if($active) {
                $msg = "Get Active Scholarships";
                $data = $scholarships->getActive();
            } else {
                $msg = "Get All Scholarships";
                $data = $scholarships->getAll();
            }
            if($search) {
                $searchService = $this->container->get('SearchService');
                $query = $request->getQueryParams();
                $msg .= ". SEARCH: ".json_encode($query);
                $data = $searchService->searchScholarships($data, $query);
            }
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
