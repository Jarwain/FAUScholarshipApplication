<?php
namespace ScholarshipApi\Model\User;

class UserDatabase implements UserStore{
    var $db;
    var $factory;

    function __construct(\PDO $db){
        $this->db = $db;
    }

    public function getAll(){
        $query = "SELECT name
                    FROM `user`";
        return $this->db->query($query)->fetchAll();
    }

    public function get($name){
        $query = "SELECT name, password
                    FROM `user` 
                    WHERE name = :name";
        $stmnt = $this->db->prepare($query);
        $stmnt->execute([':name' => $name]);
        $result = $stmnt->fetch();
        if(empty($result)){
            throw new \OutOfBoundsException("User $name not found.");
        } else {
            return new User($result['name'], $result['password']);
        }
    }

    public function create($user){
        $query = "INSERT INTO `user` (name, password)
                    VALUES (:name, :pass)";
        $stmnt = $this->db->prepare($query);
        $stmnt->execute([':name' => $user->getName(), ':pass' => $user->getPassword()]);
    }

    public function update($user){
        $query = "UPDATE `user`
                    SET password = :pass 
                    WHERE name = :name";
        $stmnt = $this->db->prepare($query);
        $stmnt->execute([':name' => $user->getName(), ':pass' => $user->getPassword()]);
    }
}