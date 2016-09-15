<?php

class PDODatabase {
	private $db;

	function __construct($db){
		$this->db = $db;
	}

	public function getQuestionFromDB($id){
		$query = $db->prepare("SELECT `id`,`type`,`question`,`settings` FROM `question` WHERE `id` = :id");
		$query->execute(array("id"=>$id));
		$instance = new self($query->fetch());
		return $instance;
	}

	// Parameters: type, question, settings. Returns id
	public function saveQuestionToDB($question){
		// TODO: Validate Questions
		// 
		$question['settings'] = json_encode($question['settings']);
		$query = $db->prepare('INSERT INTO `question` (`type`, `question`, `settings`) VALUES (:type, :question, :settings)');
		$query->execute($question);
		return $db->lastInsertId();
	}

	public function getQuestionsByScholarship($code){

		$query = $db->prepare('SELECT Q.`id`,`type`,`question`,`settings` FROM `scholarship_question` S INNER JOIN `question` Q ON S.`questionID`= Q.`id` WHERE `code` = :code');
		$query->bindParam(":code", $code);
		$query->execute();
		foreach ($query->fetchAll() as $q) {
			$out[] = $instance = new self($q);
		}
		return $out;
	}

	public function deleteQuestionsByScholarship($code){
		// Delete scholarship question relationships to avoid key conflict
		$question = $db->prepare('DELETE FROM `scholarship_question` WHERE `code` = :code');
		$question->execute(array("code"=>$code));
		return true;
	}
}
?>