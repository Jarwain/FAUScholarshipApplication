<?php
namespace ScholarshipApi\Model\File;

class FileDatabase implements FileStore{
	var $db;

	function __construct(\PDO $db){
		$this->db = $db;
	}

	function getAll(){
		throw \BadMethodCallException("Pls don't get all files");
	}

	function get($id){
		$query = "SELECT id, name, md5, data, size, created, znumber
                    FROM `file` 
                    WHERE id = :id";
        $stmnt = $this->db->prepare();
        $stmnt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmnt->execute();
        $result = $stmnt->fetch();

        return $result;
   	}

	function getIdByMd5($md5){
		$query = "SELECT id
                    FROM `file` 
                    WHERE md5 = :md5";
        $stmnt = $this->db->prepare($query);
        $stmnt->bindParam(':md5', $md5, \PDO::PARAM_STR);
        $stmnt->execute();

        $result = $stmnt->fetch()['id'];
        return $result;
	}

	function save($item){
		$query = "INSERT IGNORE INTO `file` (name, md5, data, size)
					VALUES (:name, :md5, :data, :size)";
        $stmnt = $this->db->prepare($query);
        [
            'znumber' => $znumber,
            'file' => $file,
        ] = $item;
        
        $stmnt->bindParam(':name', $file['name'], \PDO::PARAM_STR);
        $stmnt->bindParam(':size', $file['size'], \PDO::PARAM_INT);
        $stmnt->bindParam(':data', $file['data'], \PDO::PARAM_INT);
        $stmnt->bindParam(':md5', $file['md5'], \PDO::PARAM_STR);
        $stmnt->execute();

        $id = $this->getIdByMd5($file['md5']);

        $query = "INSERT IGNORE INTO `student_file` (file_id, znumber)
                    VALUES (:file_id, :znumber)";
        $stmnt = $this->db->prepare($query);
        $stmnt->bindParam(':file_id', $id, \PDO::PARAM_INT);
        $stmnt->bindParam(':znumber', $znumber, \PDO::PARAM_STR);
        $stmnt->execute();

        return $id;
	}

    function delete($item){
        throw new Exception("File Delete not implemented yet", 1);
        
    }
}
