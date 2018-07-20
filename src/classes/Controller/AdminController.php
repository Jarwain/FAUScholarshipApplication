<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

use ScholarshipApi\Authenticator;

class AdminController extends AbstractController{
    protected $renderer;
    protected $session;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
        $this->renderer = $container->get('renderer');
        $this->session = $container->get('session');
    }

    public function login(Request $request, Response $response){
        $this->session['login_attempt'] = $this->session['login_attempt'] ?? 0;

        if($request->isPost()){
            $body = $request->getParsedBody();
            $auth = $this->container->get('AuthenticationService')->authorize($body['name'], $body['password']);
            if($auth){
                $this->session['auth'] = [
                    'user' => $body['name']
                ];
                $uri = $request->getUri()->getBasePath().'/admin/';
                return $response->withRedirect($uri, 303);
            } else { // Authentication Fails
                $this->session['login_attempt'] = $this->session['login_attempt'] + 1;
            }
        }

        $data = [
            'subtitle' => "Admin",
            'styles' => [
                '/dashboard.css'
            ],
            'showSearch' => false,
            'showSignOut' => false,
            'body' => [
                'template' => 'admin/login.phtml',
                'data' => [
                    'attempt' => $this->session['login_attempt']
                ]
            ]
        ];
        return $this->renderer->render($response, "admin/admin_layout.phtml", $data);
    }

    public function home(Request $request, Response $response){
        $data = [
            'subtitle' => "Admin",
            'styles' => [
                '/dashboard.css'
            ],
            'sidenav' => [
                'template' => 'admin/sidenav.phtml',
                'data' => [
                ]
            ],
            'body' => [
                'template' => 'admin/index.phtml',
                'data' => [
                ]
            ]
        ];
        return $this->renderer->render($response, "admin/admin_layout.phtml", $data);
    }
}
