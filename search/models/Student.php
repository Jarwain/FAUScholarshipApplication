<?php
require_once("models/Qualifier.php");
require_once("models/Restriction.php");
	class Student {
		var $znumber;
		var $qualifications;

		function __construct($znumber){
			$this->znumber = $znumber;
			$this->qualifications = array();
		}

		function isQualified($restrictions){
			return array_reduce($restrictions, function($c,$i){
				if($c === true)
					return $i->qualifies($this->qualifications[$i->qualifier_id]);
				return false;
			}, true);
		}

		// returns student if qualifications are valid. else returns false
		static function studentFactory($znumber,$qualifications){
			$student = new Student($znumber);
			if($qualifications->areValid()){

			} else {
				return NULL;
			}
			
		}
	}

?>