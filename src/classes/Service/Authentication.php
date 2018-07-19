<?php
namespace ScholarshipApi\Service;

use ScholarshipApi\Model\User\UserStore;

class Authentication{
    var $users;
    var $log;

    function __construct(UserStore $users, $logger){
        $this->users = $users;
        $this->log = $logger;
    }

    public function authorize($name, $password){
        try{
            $user = $this->users->get($name);
            if(password_verify($password, $user->getPassword())){
                if(password_needs_rehash($user->getPassword(), PASSWORD_DEFAULT)){
                    $user->setPassword($password);
                    $this->users->update($user);
                }
                $this->log->info("Authorize {$user->getName()}: PASS");
                return true;
            } else {
                $this->log->info("Authorize {$user->getName()}: FAIL");
            }
        } catch(\OutOfBoundsException $ex){
            $this->log->info($ex->getMessage());
        }
        return false;
    }

}