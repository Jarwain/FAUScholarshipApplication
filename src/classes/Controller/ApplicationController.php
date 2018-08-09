<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

use ScholarshipApi\View\ViewBuilder;
use ScholarshipApi\View\ApplicationView;

class ApplicationController extends AbstractController{
    protected $session;
    protected $renderer;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
        $this->session = $container->get('session');        
        $this->renderer = $container->get('renderer');
    }

    public function index(Request $request, Response $response, $args){
    	$qualifiers = $this->container->get('QualifierStore')->getAll();
    	$data['obj'] = [
    		'qualifiers' => $qualifiers
    	];

    	return $this->renderer->render($response, 'application/index.phtml', $data);
    }

    public function studentForm(Request $request, Response $response){
        $qualifiers = $this->container->get('QualifierStore')->getAllByName();
        if($request->isPost()){
        	$body = $request->getParsedBody();

        	$student = new \ScholarshipApi\Model\Student\Student($body['znumber'], $body['first_name'], 
        		$body['last_name'], $body['email']);
        	$errors = [];
        	foreach($body as $name=>$val){
        		if(array_key_exists($name, $qualifiers)){
        			$student->addQualification($qualifiers[$name]->getId(), $val);
        			
        			$res = $qualifiers[$name]->validate($val); // Validate submitted Value. 
        			if($res !== True) $errors[$name] = $res; // If it's not true, add an error 
        		}
        	}
        	$this->session['student'] = $student;
        	if(empty($errors)){
        		$uri = $request->getUri()->getBasePath().'/application/select/';
                return $response->withRedirect($uri, 303);
        	}
        }
        $student = $this->session['student'] ?? Null;

        $view = new ViewBuilder('application/layout.phtml');
		$view = ApplicationView::navbar($view);
		$view = ApplicationView::studentForm($view, $qualifiers, $student);

		return $view->render($this->renderer, $response);
    }

    public function scholarshipSelect(Request $request, Response $response){
    	$scholarships = $this->container->get('ScholarshipStore')->getAll();
    	$applicable = array_filter($scholarships, function($e){return $e->isApplicable();});

        $view = new ViewBuilder('application/layout.phtml');
		$view = ApplicationView::navbar($view);
		$view = ApplicationView::scholarshipSelect($view, $applicable);

		return $view->render($this->renderer, $response);
    }
}