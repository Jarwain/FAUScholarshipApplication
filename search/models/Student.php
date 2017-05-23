<?php
require_once("models/Qualifier.php");
require_once("models/Restriction.php");
	class Student{
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
			$student->qualifications = Qualifier::getQualifiers();
			foreach($qualifications as $key=>$val){
				if(array_key_exists($key,$student->qualifications)){
					switch($student->qualifications[$key]->type){
						case 1:
							if($val === 'true' || $val === 'false'){
								$student->qualifications[$key]->value =
									$val === 'true' ? true : false;
							} else { return false; }
							break;
						case 2:
							$param = $student->qualifications[$key]->value->param;
							$num = floatval($val);
							if($num >= $param[0] && $num <= $param[1]){
								$student->qualifications[$key]->value = $val;
							}	else { return false; }
							break;
						case 3:
							$param = $student->qualifications[$key]->value->param;
							if(in_array($val,$param)){
								$student->qualifications[$key]->value = $val;
							} else { return false; }
							break;
						case 4:
							$param = $student->qualifications[$key]->value->param;
							break;
					}
				}
			}
			return $student;
		}
	}

?>