<?php
namespace ScholarshipApi;

class Authenticator{
    var $db;
    var $log;

    function __construct(\PDO $db, $logger){
        $this->db = $db;
        $this->log = $logger;
    }

    public function createUser($user, $pass){
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $query = "INSERT INTO `auth` (user, pass)
                    VALUES (:user, :pass)";
        $stmnt = $this->db->prepare($query);
        $stmnt->execute([':user' => $user, ':pass' => $hash]);
        $result = $stmnt->fetchAll();
    }

    public function updateUser($user, $pass){
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE `auth`
                    SET pass = :pass 
                    WHERE user = :user";
        $stmnt = $this->db->prepare($query);
        $stmnt->execute([':user' => $user, ':pass' => $newHash]);
        $result = $stmnt->fetchAll();
    }

    public function authenticate($user, $pass){
        $query = "SELECT user, pass
                    FROM `auth` 
                    WHERE user = :user";
        $stmnt = $this->db->prepare($query);
        $stmnt->execute([':user' => $user]);
        $result = $stmnt->fetchAll();

        $count = count($result);
        if($count === 1){
            $account = $result[0];
            if(password_verify($pass, $account['pass'])){
                $this->log->info("'$user' logged in");
                // Please read documentation on password_hash and password_needs_rehash to understand why this is happening
                // If you don't know why we hash passwords in the first place... You'd better google it. 
                if(password_needs_rehash($account['pass'], PASSWORD_DEFAULT)){ 
                    $this->updateUser($user, $pass);
                }
                return true;
            } else {
                $this->log->info("'$user' attempted to log in. $pass");
                return false;
            }
        } else if($count === 0){
            $this->log->info("Nonexistent user '$user' attempted to log in");
            return false;
        } else {
            throw new \OutOfBoundsException("Too many users named '$user'");
        }
    }
}