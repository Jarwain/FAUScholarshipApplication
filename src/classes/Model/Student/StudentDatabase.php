<?php
namespace ScholarshipApi\Model\Student;

class StudentDatabase implements StudentStore{
    var $db;
    var $factory;

    function __construct(\PDO $db){
        $this->db = $db;
    }

    function getAll(){
        $query = "SELECT znumber, first_name, last_name, email, videoAuth
                    FROM `student`";
        $result = $this->db->query($query)->fetchAll();
        
        return array_map(Student::DataMap, $result);;
    }

    function get($znumber){
        $query = "SELECT znumber, first_name, last_name, email, videoAuth
                    FROM `student`
                    WHERE znumber = :znumber";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':znumber', $znumber, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        if(is_null($result) || !$result){
            return Null;
        }

        return Student::DataMap($result);
    }

    function save($student){
        $query = "INSERT INTO `student` 
            (`znumber`,`first_name`,`last_name`,`email`, `videoAuth`)
            VALUES (:znumber, :first_name, :last_name, :email, :video)
            ON DUPLICATE KEY UPDATE 
            first_name=VALUES(first_name), last_name=VALUES(last_name), 
            email=VALUES(email), videoAuth=VALUES(videoAuth)";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':znumber', $student->znumber, \PDO::PARAM_STR);
        $stmnt->bindParam(':first_name', $student->first_name, \PDO::PARAM_STR);
        $stmnt->bindParam(':last_name', $student->last_name, \PDO::PARAM_STR);
        $stmnt->bindParam(':email', $student->email, \PDO::PARAM_INT);
        $stmnt->bindParam(':video', $student->videoAuth, \PDO::PARAM_BOOL);
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
