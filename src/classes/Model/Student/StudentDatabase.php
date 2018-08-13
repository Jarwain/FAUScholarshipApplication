<?php
namespace ScholarshipApi\Model\Student;

class StudentDatabase implements StudentStore{
    var $db;
    var $factory;

    function __construct(\PDO $db){
        $this->db = $db;
        // $this->factory = new StudentFactory();
    }

    function getAll(){
        $query = "SELECT znumber, first_name, last_name, email
                    FROM `student`";
        $result = $this->db->query($query)->fetchAll();
        
        return $this->factory->bulkInitialize($result);
    }

    function get($znumber){
        $query = "SELECT znumber, first_name, last_name, email
                    FROM `student`
                    WHERE znumber = :znumber";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':znumber', $znumber, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        if(is_null($result) || !$result){
            throw new \OutOfBoundsException ("Student '$znumber' doesn't exist.");
        }

        return $this->factory->initialize($result);
    }

    function save($item){
        $query = "INSERT IGNORE INTO `student` (`znumber`,`first_name`,`last_name`,`email`)
                    VALUES (:znumber, :first_name, :last_name, :email)";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':znumber', $item['znumber'], \PDO::PARAM_STR);
        $stmnt->bindParam(':first_name', $item['first_name'], \PDO::PARAM_STR);
        $stmnt->bindParam(':last_name', $item['last_name'], \PDO::PARAM_STR);
        $stmnt->bindParam(':email', $item['email'], \PDO::PARAM_INT);
        $stmnt->execute();
    }

    function delete($id){
        $query = "DELETE FROM `question`
                    WHERE id = :id";
        $stmnt = $this->db->prepare($query);
        $stmnt->bindParam(':id', $id, \PDO::PARAM_STR);
        return $stmnt->execute();
    }

}
