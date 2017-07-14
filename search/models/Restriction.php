<?php
	class Restriction {
		var $qualifier_id;
		var $sch_code;
		var $category;
		var $valid;

		function __construct($qualifier_id, $sch_code, $category, $valid){
			$this->qualifier_id = $qualifier_id;
			$this->sch_code = $sch_code;
			$this->category = $category;
			$this->valid = json_decode($valid);
		}

		function isQualified($qualification){
			switch($qualification->type){
				case 1:
					if(!($qualification->param == true))
						return false;
					break;
				case 2:
					$param = $this->valid->param;
					if(!($qualification->param >= $param[0] && $qualification->param <= $param[1]))
						return false;
					break;
				case 3:
					$param = $this->valid->param;
					if(!(in_array($qualification->param,$param)))
						return false;
					break;
				case 4:
					break;
			}
			return true;
		}

		public static function array_to_restriction($arr){
			return new Restriction($arr['qualifier_id'],$arr['sch_code'],$arr['category'],$arr['valid']);
		}
	}

?>