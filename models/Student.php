<?php
require_once("Qualifier.php");
require_once("Requirement.php");
require_once("DataAccessor.php");

class Student {
	var $znumber;
	var $qualifications;

	function __construct($znumber, $qualifications){
		$this->znumber = $znumber;
		$this->qualifications = $qualifications;
	}

	// $result[0] Ultimate Boolean for Qualification
	// $result[$cat]['val'] Boolean for Category
	// $result[$cat]['err'] Contains Errors for individual Categories, $id=>$message
	function qualifiesFor($scholarship, $qualifiers){
		$reqSets = $scholarship->condensedRequirements();
		$result = [];
		if(is_array($reqSets) || is_object($reqSets)){
			foreach ((array) $reqSets as $cat => $set) {
				$catRes = $this->passesRequirements($set, $qualifiers);
				
				$result[$cat]['val'] = $catRes['val'];
				$result[$cat]['err'] = $catRes['err'];
			}
		} else {
			$result['*']['val'] = true;
		}

		$result[0] = array_reduce($result, function($a, $e){
				return ($a || $e['val']);
			}, false);
		return $result;
	}

	function passesRequirements(array $set, $qualifiers){
		$err = [];
		$result = true;
		foreach($set as $id=>$req){
			$valid = $qualifiers->get($id)->validate($this->qualifications[$id], $req->getParam());
			if($valid->res == false){
				$result = false;
				$err[$id] = $valid;
			}
		}
		return ['val' => $result, 'err' => $err];
	}

	static function ValidatingFactory($znumber, $values, $qualifiers){
		$qualarr = $qualifiers->qualifiers;
		$qualifications = $values; // Save submitted values in Student

		$err = array();
		foreach($qualarr as $id=>$qualifier){
			if(!array_key_exists($id, $qualifications)){ // If Student did not give an answer
				$qualifications[$id] = NULL;
			} else {
				$valid = $qualifier->isValid($qualifications[$id]); // Validate Student's Submission
				if($valid->res === false){ // if Invalid
					$err[$id] = $valid->message;
				}
			}
		}
		$stu = new Student($znumber, $qualifications);
		
		if(count($err) > 0)
			return array('student' => $stu, 'errors' => $err);
		else
			return $stu;

	}
}

?>