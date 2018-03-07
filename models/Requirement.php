<?php
/*
How Requirement Categories Work
For a given scholarship, its Requirements are broken into categories. A category has a single character identifier.
For a student to qualify for a scholarship, they must pass all restrictions in a single category. 
A || B || C || D

For example, given a scholarship that requires a 3.0 GPA for Graduates or 2.5GPA for undergraduates
(GPA >= 3.0 && Class Standing == Graduate) || (GPA >= 2.5 && Class Standing == Undergraduate)
This scholarship would have four restrictions broken into two categories. 
Category a
	GPA >= 3.0
	Class Standing = Graduate
Category b
	GPA >= 2.5
	Class Standing = Undergraduate (Freshman, Sophomore, Junior, Senior)
Students that qualify for this scholarship fulfill all requirements in Either category.


There also exists a wildcard category '*'
If a wildcard category exists for a given scholarship, 
Students must satisfy all requirements in the wildcard category as well as any other single category
* && (A || B || C ...)

For example, given a scholarship that requires a FAFSA, and a 3.0 GPA for Graduates or 2.5GPA for undergraduates
FAFSA == True && ((GPA >= 3.0 && Class Standing == Graduate) || (GPA >= 2.5 && Class Standing == Undergraduate))
This scholarship would have five restrictions broken into three categories 
Category *
	FAFSA == True
Category a
	GPA >= 3.0
	Class Standing = Graduate
Category b
	GPA >= 2.5
	Class Standing = Undergraduate (Freshman, Sophomore, Junior, Senior)

 */

class Requirement {
	var $qualifier_id;
	var $sch_code;
	var $category;
	var $valid;

	function __construct($qualifier_id, $sch_code, $category, $valid){
		$this->qualifier_id = $qualifier_id;
		$this->sch_code = $sch_code;
		$this->category = $category;
		$this->valid = json_decode($valid, true)['param'];
	}

	function getParam(){
		if(is_null($this->valid))
			return ['true'];
		else return $this->valid;
	}

	function qualifies($qualifier, $value){
		// If the restriction is a boolean
		if(is_null($this->valid))
			$param = ['true'];
		else $param = $this->valid;
		
		return $qualifier->validate($value, $param);
	}


	function printHTML(){
		$param = json_encode($this->getParam());
		return "{$this->qualifier_id}:{$param}</br>";
	}
	
	public static function array_to_restriction($arr){
		return new Requirement($arr['qualifier_id'],$arr['sch_code'],$arr['category'],$arr['valid']);
	}
}

?>