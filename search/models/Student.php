<?php
require_once("models/Qualifier.php");
	class Student{
		var $znumber;
		var $qualifications;

		function __construct($znumber){
			$this->znumber = $znumber;
			$this->qualifications = array();
		}

		// returns student if qualifications are valid. else returns false
		static function validStudent($znumber,$qualifications){
			echo "a";
			$student = new Student($znumber);
			$student->qualifications = Qualifier::getQualifiers();
			echo "b";
			foreach($qualifications as $key->$val){
				if(array_key_exists($key,$student->qualifications)){
					switch($student->qualifications[$key]->type){
						case 1: 
							if($val === 'true' || $val === 'false'){
								$student->qualifications[$key]->value = 
									$val === 'true' ? true : false;
							} else { return false; }
							break;
						case 2:
							$param = json_decode($student->qualifications[$key]->value)->param;
							$num = floatval($val);
							if($num >= $param[0] && $num <= $param[1])
								$student->qualifications[$key]->value = $val;
							else return false;
							break;
						case 3:
							$param = json_decode($student->qualifications[$key]->value)->param;
							if(in_array($val,$param))
								$student->qualifications[$key]->value = $val;
							else 
								return false;
							break;
						case 4:
							$param = json_decode($student->qualifications[$key]->value)->param;
							break;
					}
				}
			}
			return $student;
		}
	}

?>