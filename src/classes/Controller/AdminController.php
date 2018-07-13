<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

use ScholarshipApi\Authenticator;

class AdminController extends Controller{
    protected $renderer;
    protected $session;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
        $this->renderer = $container->get('renderer');
        $this->session = $container->get('session');
    }

    public function login(Request $request, Response $response){
        $this->session['login_attempt'] = $this->session['login_attempt'] ?? 0;

        $auth = new Authenticator($this->container->get('db'), $this->container->get('logger'));
        if($request->isPost()){
            $body = $request->getParsedBody();
            if($auth->authenticate($body['user'], $body['password'])){
                $this->session['auth'] = [
                    'user' => $body['user']
                ];
                $uri = $request->getUri()->getBasePath().'/admin/';
                return $response->withRedirect($uri, 303);
            } else { // Authentication Fails
                $this->session['login_attempt'] = $this->session['login_attempt'] + 1;
            }
        }

        $data = [
            'attempt' => $this->session['login_attempt']
        ];
        return $this->renderer->render($response, "login.phtml", $data);
    }

    public function home(Request $request, Response $response){
        return $this->renderer->render($response, "index.phtml");
    }
}
