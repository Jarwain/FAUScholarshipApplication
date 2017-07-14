<?php
require_once("models/Qualifier.php");
require_once("models/Restriction.php");
	class Student {
		var $znumber;
		var $qualifications;

		function __construct($znumber, $quals = array()){
			$this->znumber = $znumber;
			$this->qualifications = $quals;
		}

		function isQualified($restrictions){
			return array_reduce($restrictions, function($c,$i){
				if($c === true)
					return $i->isQualified($this->qualifications[$i->qualifier_id]);
				return false;
			}, true);
		}

		// returns student if qualifications are valid. else returns false
		static function studentFactory($znumber,$qualifications){
			$result = $qualifications->areValid();
			if($result){
				return new Student($znumber,$result);
			} else {
				return NULL;
			}
			
		}
	}

?>