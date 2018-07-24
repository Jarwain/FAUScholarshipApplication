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
        $dataBuilder->addAttribute('subtitle', 'Admin');
        $dataBuilder->addPart('body', 'admin/login.phtml', [
            'attempt' => $this->session['login_attempt']
        ]);

        return $this->renderer->render($response, "admin/admin_layout.phtml", $dataBuilder->getData());
    }

    public function logout(Request $request, Response $response){
        $this->authenticator->revokeAuthentication();

        $dataBuilder = new DataBuilder();
        $dataBuilder->addAttribute('subtitle', 'Admin');
        $dataBuilder->addPart('body', 'admin/logout.phtml');

        return $this->renderer->render($response, "admin/admin_layout.phtml", $dataBuilder->getData());
    }

    public function scholarshipList(Request $request, Response $response){
        $dataBuilder = new DataBuilder();
        $dataBuilder->addAttribute('subtitle','Admin');
        $dataBuilder->addPart('navbar', 'admin/navbar.phtml', [
            'active' => 'scholarships'
        ]);

        $scholarships = $this->container->get('ScholarshipStore')->getAll();
        $dataBuilder->addPart('body', 'admin/scholarships.phtml', [
            'scholarships' => $scholarships
        ]);

        return $this->renderer->render($response, "admin/admin_layout.phtml", $dataBuilder->getData());
    }
}
