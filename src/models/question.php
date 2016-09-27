<?php

class Question {
	public $id;
	public $type;
	public $question;
	public $settings;

	function __construct(array $row){
		$this->id = $row['id'];
		$this->type = $row['type'];
		$this->question = $row['question'];
		$this->settings = json_decode($row['settings']);
	}

	public static function getQuestion($db, $id){
		$query = $this->db->prepare("SELECT `id`,`type`,`question`,`settings` FROM `question` WHERE `id` = :id");
		$query->execute(array("id"=>$id));
		$instance = new Question($query->fetch());
		return $instance;
	}

	// Parameters: type, question, settings. Returns id
	public static function saveQuestion($db, $question){
		// TODO: Validate Questions
		// 
		$question['settings'] = json_encode($question['settings']);
		$query = $this->db->prepare('INSERT INTO `question` (`type`, `question`, `settings`) VALUES (:type, :question, :settings)');
		$query->execute($question);
		return $this->db->lastInsertId();
	}

	public static function getQuestionsByScholarship($db, $code){
		$out = [];
		$query = $db->prepare('SELECT Q.`id`,`type`,`question`,`settings` FROM `scholarship_question` S INNER JOIN `question` Q ON S.`questionID`= Q.`id` WHERE `code` = :code');
		$query->bindParam(":code", $code);
		$query->execute();
		foreach ($query->fetchAll() as $q) {
			$out[] = $instance = new Question($q);
		}
		return $out;
	}

	public static function deleteQuestionsByScholarship($db, $code){
		// Delete scholarship question relationships to avoid key conflict
		$question = $db->prepare('DELETE FROM `scholarship_question` WHERE `code` = :code');
		$question->execute(array("code"=>$code));
		return true;
	}
}