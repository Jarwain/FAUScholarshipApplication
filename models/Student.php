<?php
require_once("Qualifier.php");
require_once("Qualification.php");
require_once("Restriction.php");

class Student {
	var $znumber;
	var $qualifications;

	function __construct($znumber, ArrayOfQualifications $quals){
		$this->znumber = $znumber;
		$this->qualifications = $quals->qualifications;
	}

	function isQualified($restrictions){
		return array_reduce($restrictions, function($c,$i){
			if($c === true)
				return $i->isQualified($this->qualifications[$i->qualifier_id]);
			return false;
		}, true);
	}

	// returns student if qualifications are valid. else returns false
	static function Factory($znumber, $qualifications){
		$result = $qualifications->areValid();
		if($result){
			return new Student($znumber,$result);
		} else {
			return NULL;
		}
		
	}
}

?>