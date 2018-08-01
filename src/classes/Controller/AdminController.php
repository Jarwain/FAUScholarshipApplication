<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

use ScholarshipApi\Util\DataBuilder;
use ScholarshipApi\View\ViewBuilder;
use ScholarshipApi\View\ViewPart;

class AdminController extends AbstractController{
    protected $renderer;
    protected $session;
    protected $authenticator;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
        $this->session = $container->get('session');
        $this->authenticator = $container->get('authenticator');
        
        $this->renderer = $container->get('renderer');
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


        $view = new ViewBuilder('admin/admin_layout.phtml');
		$body = new ViewPart('admin/login.phtml');
		$body->addAttributes([
            'attempt' => $this->session['login_attempt']
        ]);
		$view->addPart('body', $body);

		return $view->render($this->renderer, $response);
    }

    public function logout(Request $request, Response $response){
        $this->authenticator->revokeAuthentication();
        $view = new ViewBuilder('admin/admin_layout.phtml');
		$view->addPart('body', new ViewPart('admin/logout.phtml'));

		return $view->render($this->renderer, $response);
    }

    public function scholarshipView(Request $request, Response $response, $args){
    	$navbar = new ViewPart('admin/navbar.phtml');
    	$navbar->addAttribute('active','scholarships');

    	$view = new ViewBuilder('admin/admin_layout.phtml');
    	$view->addPart('navbar', $navbar);

    	if(isset($args['code'])){
	    	$action = $args['action'] ?? NULL;
			$scholarship = $this->container->get('ScholarshipStore')->get($args['code']);

			switch($action){
				case 'edit':
					$body = new ViewPart('admin/scholarship_editor.phtml');
				    $body->addScript('vue.js');
	    			$body->addScript('admin/scholarship_editor.js');
	    			$body->addAttribute('questions', $this->container->get('QuestionStore')->getAll());
	    			$body->addAttribute('qualifiers', $this->container->get('QualifierStore')->getAll());
					break;
				case 'view':
				default:
			    	// View specific Scholarship
					$body = new ViewPart('admin/scholarship_item.phtml');
					break;
			}

			$body->addAttribute('scholarship', $scholarship);
    	} else {
			// List all scholarships
	        $scholarships = $this->container->get('ScholarshipStore')->getAll();
	        $body = new ViewPart('admin/scholarship_list.phtml');
	        $body->addAttribute('scholarships', $scholarships);
    	}
    	$view->addPart('body', $body);
	    return $view->render($this->renderer, $response);
    }

    public function questionView(Request $request, Response $response, $args){
    	$questions = $this->container->get('QuestionStore')->getAll();

	    $navbar = new ViewPart('admin/navbar.phtml');
    	$navbar->addAttribute('active','questions');

    	$body = new ViewPart('admin/question_list.phtml');
    	$body->addAttribute('questions', $questions);

    	$view = new ViewBuilder('admin/admin_layout.phtml');
    	$view->addPart('navbar', $navbar);
    	$view->addPart('body', $body);

        return $view->render($this->renderer, $response);
    }

    public function qualifierView(Request $request, Response $response, $args){
    	$qualifiers = $this->container->get('QualifierStore')->getAll();
		
		$navbar = new ViewPart('admin/navbar.phtml');
    	$navbar->addAttribute('active','qualifiers');

    	$body = new ViewPart('admin/qualifier_list.phtml');
    	$body->addAttribute('qualifiers', $qualifiers);

    	$view = new ViewBuilder('admin/admin_layout.phtml');
    	$view->addPart('navbar', $navbar);
    	$view->addPart('body', $body);

        return $view->render($this->renderer, $response);
    }

    public function createItem(Request $request, Response $response, $args){
    	$itemType = $args['item'] ?? NULL;

    	$navbar = new ViewPart('admin/navbar.phtml');
    	switch($itemType){
    		case "scholarship":
    			$navbar->addAttribute('active','scholarships');
    			$body = new ViewPart('admin/scholarship_editor.phtml');
    			$body->addScript('vue.js');
    			$body->addScript('admin/scholarship_editor.js');
    			$body->addAttribute('questions', $this->container->get('QuestionStore')->getAll());
	    		$body->addAttribute('qualifiers', $this->container->get('QualifierStore')->getAll());
    			break;
    		case "question":
    			$navbar->addAttribute('active','questions');
    			$body = new ViewPart('admin/question_editor.js');
    			break;
    		case "qualifier":
    			$navbar->addAttribute('active','qualifiers');
    			$body = new ViewPart('admin/qualifier_editor.js');
    			break;
    		default:
    			throw new \Slim\Exception\NotFoundException($request, $response);
    			break;
    	}

    	$view = new ViewBuilder('admin/admin_layout.phtml');
    	$view->addPart('navbar', $navbar);
    	$view->addPart('body', $body);
    	return $view->render($this->renderer, $response);
    }
}