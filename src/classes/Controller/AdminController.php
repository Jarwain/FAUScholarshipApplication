<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

use ScholarshipApi\Util\DataBuilder;

class AdminController extends AbstractController{
    protected $renderer;
    protected $session;
    protected $authenticator;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
        $this->renderer = $container->get('renderer');
        $this->session = $container->get('session');
        $this->authenticator = $container->get('authenticator');
    }

    public function login(Request $request, Response $response){
        $this->session['login_attempt'] = $this->session['login_attempt'] ?? 0;

        if($request->isPost()){
            $body = $request->getParsedBody();

            $this->authenticator->authenticate($body['name'], $body['password']);
            if($this->authenticator->isAuthenticated()){
                $uri = $request->getUri()->getBasePath().'/admin/';
                return $response->withRedirect($uri, 303);
            } else { // Authentication Fails
                $this->session['login_attempt'] = $this->session['login_attempt'] + 1;
            }
        }

        $dataBuilder = new DataBuilder();
        $dataBuilder->addAttribute('subtitle', 'Panel');
        $dataBuilder->addPart('body', 'admin/login.phtml', [
            'attempt' => $this->session['login_attempt']
        ]);

        return $this->renderer->render($response, "admin/admin_layout.phtml", $dataBuilder->getData());
    }

    public function logout(Request $request, Response $response){
        $this->authenticator->revokeAuthentication();

        $dataBuilder = new DataBuilder();
        $dataBuilder->addAttribute('subtitle', 'Panel');
        $dataBuilder->addPart('body', 'admin/logout.phtml');

        return $this->renderer->render($response, "admin/admin_layout.phtml", $dataBuilder->getData());
    }

    public function scholarshipView(Request $request, Response $response, $args){
    	if(isset($args['code'])){
    		// If viewing specific Scholarship
    		$scholarship = $this->container->get('ScholarshipStore')->get($args['code']);
    		$dataBuilder = new DataBuilder();
    		$dataBuilder->addAttribute('subtitle','Panel');
    		$dataBuilder->addPart('navbar', 'admin/navbar.phtml', [
	            'active' => 'scholarships'
    		]);
    		$dataBuilder->addPart('body', 'admin/scholarship_item.phtml', [
	            'scholarship' => $scholarship
	        ]);

    		return $this->renderer->render($response, "admin/admin_layout.phtml", $dataBuilder->getData());
    	} else {
    		// Else list all scholarships
	        $scholarships = $this->container->get('ScholarshipStore')->getAll();
	        
	        $dataBuilder = new DataBuilder();
	        $dataBuilder->addAttribute('subtitle','Panel');
	        $dataBuilder->addPart('navbar', 'admin/navbar.phtml', [
	            'active' => 'scholarships'
	        ]);
	        $dataBuilder->addPart('body', 'admin/scholarship_list.phtml', [
	            'scholarships' => $scholarships
	        ]);

	        return $this->renderer->render($response, "admin/admin_layout.phtml", $dataBuilder->getData());
    	}
    }

    public function questionView(Request $request, Response $response, $args){
    	$questions = $this->container->get('QuestionStore')->getAll();
	        
        $dataBuilder = new DataBuilder();
        $dataBuilder->addAttribute('subtitle','Panel');
        $dataBuilder->addPart('navbar', 'admin/navbar.phtml', [
            'active' => 'questions'
        ]);
        $dataBuilder->addPart('body', 'admin/question_list.phtml', [
            'questions' => $questions
        ]);

        return $this->renderer->render($response, "admin/admin_layout.phtml", $dataBuilder->getData());
    }

    public function qualifierView(Request $request, Response $response, $args){
    	$qualifiers = $this->container->get('QualifierStore')->getAll();
	        
        $dataBuilder = new DataBuilder();
        $dataBuilder->addAttribute('subtitle','Panel');
        $dataBuilder->addPart('navbar', 'admin/navbar.phtml', [
            'active' => 'qualifiers'
        ]);
        $dataBuilder->addPart('body', 'admin/qualifier_list.phtml', [
            'qualifiers' => $qualifiers
        ]);

        return $this->renderer->render($response, "admin/admin_layout.phtml", $dataBuilder->getData());
    }

    public function createItem(Request $request, Response $response, $args){
    	$itemType = $args['item'] ?? NULL;
    	switch($itemType){
    		case "scholarship":
    			break;
    		case "question":
    			break;
    		case "qualifier":
    			break;
    		default:
    			break;
    	}
    }
}