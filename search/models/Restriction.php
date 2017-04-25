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

	public static function array_to_restriction($arr){
		return new Restriction($arr['qualifier_id'],$arr['sch_code'],$arr['category'],$arr['valid']);
	}
}

?>