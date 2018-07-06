<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

class AdminController {
    protected $container;
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
            if(false){ // Authentication passes

                return $this->home($request, $response);
            } else { // Authentication Fails
                $this->session['login_attempt'] = $this->session['login_attempt'] + 1;
            }
            // Do Authentication
            // if Authenticated
                // set session cookie
                // redirect to 'home'
            // if authentication fails
                // Reload login page
        }
        $data = [
            'attempt' => $this->session['login_attempt']
        ];
        return $this->renderer->render($response, "login.php")
    }

    public function home(Request $request, Response $response){
        
    }
}
