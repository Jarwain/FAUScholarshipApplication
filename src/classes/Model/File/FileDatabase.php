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
        $stmnt = $this->db->prepare();
        $stmnt->bindParam(':md5', $md5, \PDO::PARAM_STR);
        $stmnt->execute();
        return $stmnt->fetch();
	}

	function save($item){
		$query = "INSERT IGNORE INTO `file` (name, md5, data, size, znumber)
					VALUES (:name, :md5, :data, :size, :znumber)";
        $stmnt = $this->db->prepare($query);
        
        $stmnt->bindParam(':name', $item['name'], \PDO::PARAM_STR);
        $stmnt->bindParam(':znumber', $item['znumber'], \PDO::PARAM_STR);
        $stmnt->bindParam(':md5', $item['md5'], \PDO::PARAM_STR);
        $stmnt->bindParam(':data', $item['data'], \PDO::PARAM_INT);
        $stmnt->bindParam(':size', $item['size'], \PDO::PARAM_INT);
        $stmnt->execute();

        return $this->getIdByMd5($item['md5']);
	}
}
