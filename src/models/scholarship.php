<?php
require_once('/question.php')	;

class Scholarship{
	public $code;
	public $name;
	public $description;
	public $active;
	public $counter;
	public $bound;
	public $question;

	function __construct(array $row, $db = null){
		$this->code = $row['code'];
		$this->name = $row['name'];
		$this->description = $row['description'];
		$this->active = $row['active'];
		$this->counter = $row['counter'];
		$this->bound = $row['bound'];
		$this->question = empty($row['question']) ? [] : $row['question'];
	}

	public static function getScholarship($db, $code = null){
		$baseQuery = 'SELECT `code`,`name`,`description`,`active`,`counter`,`bound` FROM `scholarship`';
		if($code === null){
			$query = $db->query($baseQuery);
			foreach($query->fetchAll() as $scholarship){
				$instance = new Scholarship($scholarship);
				$instance->question = Question::getQuestionsByScholarship($db, $instance->code);
				$out[] = $instance;
			}

			return $out;
		} else {
			$query = $db->prepare($baseQuery . ' WHERE `code` = :code');
			$query->execute(["code"=>$code]);
			$query = $query->fetch();
			if($query){
				$instance = new Scholarship($query);
				// Query for Questions
				$instance->question = Question::getQuestionsByScholarship($db, $code);
			} else 
			{
				throw new genException($code . "Does not exist");
			}
			return $instance;
		}
		throw new genException("controllers/ScholarshipController::getScholarship");
	}
	
	public static function getScholarshipsAndQuestions($db, $code = null){
		$baseQuery = '
				SELECT S.`code`,S.`name`,S.`description`,S.`active`,S.`counter`,S.`bound`,Q.`id`,Q.`type`,Q.`question`,Q.`settings` FROM `scholarship` S 
				LEFT JOIN `scholarship_question` SQ ON S.`code` = SQ.`code`
				LEFT JOIN `question` Q ON SQ.`questionID`= Q.`id`';
		if($code === null){
			$query = $db->query($baseQuery);
			$ret = $query->fetchAll();
			$ret = array_reduce($ret,function($c, $i){
				if($c !== NULL){
					$last = array_pop($c);
					if($last->code == $i["code"]){
						$last->question[] = new Question(array_slice($i,-4));
						$c[] = $last;
						return $c;
					} else {
						$c[] = $last;
					}
				}
				$i["question"] = [new Question(array_slice($i,-4))];
				$i = new Scholarship($i);
				$c[] = $i;
				return $c;
			});
			return $ret;
		} else {
			$query = $db->prepare($baseQuery . ' WHERE S.`code` = :code');
			$query->execute(["code"=>$code]);
			$ret = $query->fetchAll();
			$ret = array_reduce($ret,function($c, $i){
				if($c !== NULL){
					$last = array_pop($c);
					if($last->code == $i["code"]){
						$last->question[] = new Question(array_slice($i,-4));
						$c[] = $last;
						return $c;
					} else {
						$c[] = $last;
					}
				}
				$nQuestion = new Question(array_slice($i,-4));
				if($nQuestion->id !== null)
					$i["question"] = [$nQuestion];
				$i = new Scholarship($i);
				$c[] = $i;
				return $c;
			});
			return $ret[0];
		}
		
	}

	public function exists($code = null){
		if($code === null){
			throw new genException("lolrip");
		}

		$query = $this->db->prepare('SELECT `code` FROM `scholarship` WHERE `code` = :code');
		$query->execute(array("code"=>$code));
		$result = $query->fetch();

		return !empty($result);
	}

	public function saveQuestions($scholarship){
		$scholarship->question = array_reduce($scholarship->question,function($carry,$item){
			if(empty($item['id'])){
				$carry[]['id'] = $this->QuestionController->saveQuestion($item);
			} else {
				$carry[] = $item;
			}
			return $carry;
		});
		return $scholarship;
	}

	/*public function loadQuestions(){

	}*/

	public function saveScholarship($scholarship){
		// TODO: Validate Scholarship
		if($this->exists($scholarship->code)){
			throw new genException("Scholarship already exists");
		}
		$scholarship = $this->saveQuestions($scholarship);

		// save scholarship
		$query = $this->db->prepare('INSERT INTO `scholarship` (`code`, `name`, `description`, `active`, `bound`) VALUES (:code, :name, :description, :active, :bound)');
		$query->bindParam(':code',$scholarship->code);
		$query->bindParam(':name',$scholarship->name);
		$query->bindParam(':description',$scholarship->description);
		$query->bindParam(':active',$scholarship->active);
		$query->bindParam(':bound',$scholarship->bound);
		$query->execute();
		// save question->scholarship relation
		foreach($scholarship->question as $question){
			$query = $this->db->prepare('INSERT INTO `scholarship_question` (`code`, `questionID`) VALUES (:code, :questionID)');
			$query->bindParam(':code', $scholarship->code);
			$query->bindParam(':questionID', $question['id']);
			$query->execute();
		}
		return true;
	}

	public function deleteScholarship($code){

		// Existance check
		if(!$this->exists($code)){
			throw new genException($code . " does not exist");
		}
		$this->QuestionController->deleteQuestionsByScholarship($code);
		// Delete scholarship itself
		$scholarship = $this->db->prepare('DELETE FROM `scholarship` WHERE `code` = :code');
		$scholarship->execute(array("code"=>$code));

		return true;
	}
}