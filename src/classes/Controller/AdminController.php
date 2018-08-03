<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

use ScholarshipApi\Util\DataBuilder;
use ScholarshipApi\View\ViewBuilder;
use ScholarshipApi\View\ViewPart;
use ScholarshipApi\View\AdminView;
use ScholarshipApi\View\ScholarshipView;

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
        $view = new ViewBuilder('admin/admin_layout.phtml');
        $view = AdminView::navbar($view, AdminView::ACTIVE_SCHOLARSHIPS);

        if(isset($args['code'])){
            // If only doing one scholarship
            $scholarship = $this->container->get('ScholarshipStore')->get($args['code']);
            $questions = $this->container->get('QuestionStore')->getAll();
            $qualifiers = $this->container->get('QualifierStore')->getAll();

            $action = $args['action'] ?? NULL;
            switch($action){
                case 'edit':
                    $view = ScholarshipView::edit($view, $scholarship, $questions, $qualifiers);
                    break;
                case 'view':
                default:
                    $view = ScholarshipView::item($view, $scholarship);
                    break;
            }
        } else {
            // List all scholarships
            $scholarships = $this->container->get('ScholarshipStore')->getAll();
            $view = ScholarshipView::list($view, $scholarships);
        }
        return $view->render($this->renderer, $response);
    }

    public function questionView(Request $request, Response $response, $args){
    	$questions = $this->container->get('QuestionStore')->getAll();

    	$view = new ViewBuilder('admin/admin_layout.phtml');
        $view = AdminView::navbar($view, AdminView::ACTIVE_QUESTIONS);

        $body = new ViewPart('admin/question_list.phtml');
        $body->addAttribute('questions', $questions);
    	$view->addPart('body', $body);

        return $view->render($this->renderer, $response);
    }

    public function qualifierView(Request $request, Response $response, $args){
    	$qualifiers = $this->container->get('QualifierStore')->getAll();
		
    	$view = new ViewBuilder('admin/admin_layout.phtml');
        $view = AdminView::navbar($view, AdminView::ACTIVE_QUALIFIERS);

        $body = new ViewPart('admin/qualifier_list.phtml');
        $body->addAttribute('qualifiers', $qualifiers);
    	$view->addPart('body', $body);

        return $view->render($this->renderer, $response);
    }

    public function createItem(Request $request, Response $response, $args){
    	$itemType = $args['item'] ?? NULL;

    	$view = new ViewBuilder('admin/admin_layout.phtml');
        switch($itemType){
            case "scholarship":
                $view = AdminView::navbar($view, AdminView::ACTIVE_SCHOLARSHIPS);
                $view = ScholarshipView::create($view, 
                    $this->container->get('QuestionStore')->getAll(), 
                    $this->container->get('QualifierStore')->getAll());
                break;
            case "question":
                $view = AdminView::navbar($view, AdminView::ACTIVE_QUESTIONS);
                $body = new ViewPart('admin/question_editor.js');
                $view->addPart('body', $body);
                break;
            case "qualifier":
                $view = AdminView::navbar($view, AdminView::ACTIVE_QUALIFIERS);
                $body = new ViewPart('admin/qualifier_editor.js');
                $view->addPart('body', $body);
                break;
            default:
                throw new \Slim\Exception\NotFoundException($request, $response);
                break;
        }

    	return $view->render($this->renderer, $response);
    }
}