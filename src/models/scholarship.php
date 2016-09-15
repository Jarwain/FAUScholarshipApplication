<?php

class Scholarship{
	public $code;
	public $name;
	public $description;
	public $active;
	public $counter;
	public $bound;
	public $question;

	function __construct(array $row){
		$this->code = $row['code'];
		$this->name = $row['name'];
		$this->description = $row['description'];
		$this->active = $row['active'];
		$this->counter = 0;
		$this->bound = $row['bound'];
		$this->question = empty($row['question']) ? [] : $row['question'];
	}

	function transform($mergedArray){

	}

	public static function getScholarshipFromDB($code = null){
		global $container;
		$baseQuery = 'SELECT `code`,`name`,`description`,`active`,`counter`,`bound` FROM `scholarship`';
		if($code === null){
			$query = $container->db->query($baseQuery);
			foreach($query->fetchAll() as $scholarship){
				$instance = new self($scholarship);
				$instance->question = Question::getQuestionsByScholarship($instance->code);
				$out[] = $instance;
			}

			return $out;
		} else {
			$query = $container->db->prepare($baseQuery . ' WHERE `code` = :code');
			$query->execute(["code"=>$code]);
			$query = $query->fetch();
			if($query){
				$instance = new self($query);
				// Query for Questions
				$instance->question = Question::getQuestionsByScholarship($code);
			} else 
			{
				throw new genException($code . "Does not exist");
			}
			return $instance;
		}
		throw new genException("models/scholarship::getScholarshipFromDB");
	}
	
	public static function getScholarshipsAndQuestionsFromDB($code = null){
		global $container;
		$baseQuery = '
				SELECT S.`code`,S.`name`,S.`description`,S.`active`,S.`counter`,S.`bound`,Q.`id`,Q.`type`,Q.`question`,Q.`settings` FROM `scholarship` S 
				LEFT JOIN `scholarship_question` SQ ON S.`code` = SQ.`code`
				LEFT JOIN `question` Q ON SQ.`questionID`= Q.`id`';
		if($code === null){
			$query = $container->db->query($baseQuery);
			//$query->execute(["code"=>$code]);
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
				$i = new self($i);
				$c[] = $i;
				return $c;
			});
			return $ret;
		} else {
			$query = $container->db->prepare($baseQuery . ' WHERE S.`code` = :code');
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
				$i["question"] = [new Question(array_slice($i,-4))];
				$i = new self($i);
				$c[] = $i;
				return $c;
			});
			return $ret;
		}
		
	}

	public function exists($code = null){
		if($code === null){
			$code = $this->code;
		}
		global $container;

		$query = $container->db->prepare('SELECT `code` FROM `scholarship` WHERE `code` = :code');
		$query->execute(array("code"=>$code));
		$result = $query->fetch();

		return !empty($result);
	}

	public static function deleteScholarshipFromDB($code){
		global $container;

		// Existance check
		if(!Scholarship::exists($code)){
			throw new genException($code . " does not exist");
		}
		Question::deleteQuestionsByScholarship($code);
		// Delete scholarship itself
		$scholarship = $container->db->prepare('DELETE FROM `scholarship` WHERE `code` = :code');
		$scholarship->execute(array("code"=>$code));

		return true;
	}

	public function saveQuestions(){
		$this->question = array_reduce($this->question,function($carry,$item){
			if(empty($item['id'])){
				$carry[]['id'] = Question::saveQuestionToDB($item);
			} else {
				$carry[] = $item;
			}
			return $carry;
		});
		return true;
	}

	/*public function loadQuestions(){

	}*/

	public function saveScholarship(){
		// TODO: Validate Scholarship
		if($this->exists()){
			throw new genException("Scholarship already exists");
		}
		global $container;
		$this->saveQuestions();

		// save scholarship
		$query = $container->db->prepare('INSERT INTO `scholarship` (`code`, `name`, `description`, `active`, `bound`) VALUES (:code, :name, :description, :active, :bound)');
		$query->bindParam(':code',$this->code);
		$query->bindParam(':name',$this->name);
		$query->bindParam(':description',$this->description);
		$query->bindParam(':active',$this->active);
		$query->bindParam(':bound',$this->bound);
		$query->execute();
		// save question->scholarship relation
		foreach($this->question as $question){
			$query = $container->db->prepare('INSERT INTO `scholarship_question` (`code`, `questionID`) VALUES (:code, :questionID)');
			$query->bindParam(':code', $this->code);
			$query->bindParam(':questionID', $question['id']);
			$query->execute();
		}
		return true;
	}
}