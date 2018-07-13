<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

class SearchController extends AbstractController{
    var $renderer;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
        $this->renderer = $container->get('renderer');
    }

    public function index(Request $request, Response $response){
        $qualifierStore = $this->container->get('QualifierStore');
        $data = ['qualifiers' => $qualifierStore->getAll()];

        return $this->renderer->render($response, "search/index.phtml", $data);
    }

    public function search(Request $request, Response $response){
        
    }
}