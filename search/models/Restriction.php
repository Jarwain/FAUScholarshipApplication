<?php

class Restriction{
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

	function qualifies($qualification){
		switch($qualification->type){
			case 1:
				if(!($qualification->value == true))
					return false;
				break;
			case 2:
				$param = $value->valid->param;
				if(!($qualification->value >= $param[0] && $qualification->value <= $param[1]))
					return false;
				break;
			case 3:
				if(!(in_array($qualification->value,$value->valid)))
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

	public static function isQualified($qualifications,$restrictions){
		return array_reduce($restrictions, function($c,$i){
			if($c === true)
				return $i->qualifies($qualifications);
			return false;
		}, true);
	}
}

?>