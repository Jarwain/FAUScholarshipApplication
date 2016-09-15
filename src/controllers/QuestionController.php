<?php
	require_once("/../models/question.php");

	class QuestionController{
		public $db;

		function __construct($db){
			$this->db = $db;
		}

		public function getQuestion($id){
			$query = $this->db->prepare("SELECT `id`,`type`,`question`,`settings` FROM `question` WHERE `id` = :id");
			$query->execute(array("id"=>$id));
			$instance = new Question($query->fetch());
			return $instance;
		}

		// Parameters: type, question, settings. Returns id
		public function saveQuestion($question){
			// TODO: Validate Questions
			// 
			$question['settings'] = json_encode($question['settings']);
			$query = $this->db->prepare('INSERT INTO `question` (`type`, `question`, `settings`) VALUES (:type, :question, :settings)');
			$query->execute($question);
			return $this->db->lastInsertId();
		}

		public function getQuestionsByScholarship($code){
			$out = [];
			$query = $this->db->prepare('SELECT Q.`id`,`type`,`question`,`settings` FROM `scholarship_question` S INNER JOIN `question` Q ON S.`questionID`= Q.`id` WHERE `code` = :code');
			$query->bindParam(":code", $code);
			$query->execute();
			foreach ($query->fetchAll() as $q) {
				$out[] = $instance = new Question($q);
			}
			return $out;
		}

		public function deleteQuestionsByScholarship($code){
			// Delete scholarship question relationships to avoid key conflict
			$question = $this->db->prepare('DELETE FROM `scholarship_question` WHERE `code` = :code');
			$question->execute(array("code"=>$code));
			return true;
		}

	}
?>