<?php
namespace ScholarshipApi\Model\Application;

class ApplicationDatabase implements ApplicationStore{
	var $db;

	function __construct(\PDO $db){
		$this->db = $db;
	}

	function getAll(){
		throw new \BadMethodCallException("Pls don't get all Applications");
	}

	function get($id){
		throw new Exception("Get Application not implemented yet");
        $query = "SELECT id, name, md5, data, size, created, znumber
                    FROM `file` 
                    WHERE id = :id";
        $stmnt = $this->db->prepare();
        $stmnt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        return $result;
   	}

    function getByZnumber($znumber){
        $query = "SELECT a.id, a.znumber, a.code, a.decision, a.submitted, aa.question_id, aa.answer
                    FROM `application` a
                    LEFT JOIN `application_answers` aa
                    ON a.id = aa.application_id
                    WHERE a.znumber = :znumber";
        $stmnt = $this->db->prepare($query);

        $stmnt->bindParam(':znumber', $znumber, \PDO::PARAM_STR);
        $stmnt->execute();

        $result = $stmnt->fetchAll();
        return $result;
    }

	function save($item){
        try {
            $this->db->beginTransaction();
            $query = "INSERT INTO `application` (znumber, code)
                        VALUES (:znumber, :code)";
            $stmnt = $this->db->prepare($query);
            
            $stmnt->bindParam(':znumber', $item['znumber'], \PDO::PARAM_STR);
            $stmnt->bindParam(':code', $item['code'], \PDO::PARAM_STR);
            $stmnt->execute();

            $id = $this->db->lastInsertId();
            
            /* Save Application Answers */
            $answerQuery = "INSERT INTO `application_answers` 
                (application_id, question_id, answer)
                VALUES (:id, :question, :answer)";
            $answerStmnt = $this->db->prepare($answerQuery);
            foreach ($item['answers'] as $question => $answer) {
                $answerStmnt->bindParam(':id', $id, \PDO::PARAM_INT);
                $answerStmnt->bindParam(':question', $question, \PDO::PARAM_INT);
                $answerStmnt->bindParam(':answer', $answer, \PDO::PARAM_INT);
                $answerStmnt->execute();
                $answerStmnt->closeCursor();
            }

            $this->db->commit();
        } catch (\PDOException $ex) {
            $this->db->rollback();
            [$code, $err] = $ex->errorInfo;
            if($code == 23000 && $err == 1062)
                throw new \Exception("Application already exists.");
            throw new \Exception($ex->getMessage());

        } catch (\Exception $ex) {
            $this->db->rollback();
            throw $ex;
        }
	}

    function delete($item){
        throw new Exception("Application Delete not implemented yet", 1);
    }
}
