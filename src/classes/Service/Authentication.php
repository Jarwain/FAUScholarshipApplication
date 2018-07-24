<?php
namespace ScholarshipApi\Service;

use ScholarshipApi\Model\User\UserStore;

class Authentication{
    var $users;
    var $session;
    var $log;

    function __construct(UserStore $users, $session, $logger){
        $this->users = $users;
        $this->session = $session;
        $this->log = $logger;
    }

    public function authenticate($name, $password){
        try{
            $user = $this->users->get($name);
            if(password_verify($password, $user->getPassword())){
                if(password_needs_rehash($user->getPassword(), PASSWORD_DEFAULT)){
                    $user->setPassword($password);
                    $this->users->save($user);
                }
                $this->session['auth'] = ['user' => $user->getName() ];
                $this->log->info("Authorize {$user->getName()}: PASS");
            } else {
                $this->log->info("Authorize {$user->getName()}: FAIL");
            }
        } catch(\OutOfBoundsException $ex){
            $this->log->info($ex->getMessage());
        }
    }

    public function isAuthenticated(){
        // TODO: Check for existence of user (while it shouldn't be necessary, better safe than sorry)
        return isset($this->session['auth']['user']);
    }

    public function revokeAuthentication(){
        $this->session->delete('auth');
        $this->session::destroy();
    }
}