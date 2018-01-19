<?php
require_once("Qualifier.php");

class ArrayOfQualifications{
	var $qualifications = array();

	/*
	$qualifiers - Expects ArrayOfQualifiers
	$values - Expects key: Qualifier_id | val: submitted value
	 */
	function __construct(ArrayOfQualifiers $qualifiers, array $values){
		$err = array();
		foreach($values as $key=>$val){
			try {
				$this->qualifications[$key] = new Qualification($qualifiers->get($key), $val);
			} catch (Exception $e) {
				$err[] = $e->getMessage();
			}
		}
		if(count($err) != 0) throw new Exception(json_encode($err));
	}
}
class Qualification {
	var $qualifier;
	var $value;

	function __construct(Qualifier $qualifier, $value){
		// Validate 
		if($qualifier->isValid($value)){
			$this->qualifier = $qualifier;
			$this->value = $value;
		} else {
			throw new Exception("[Qualification !isValid yet unthrown error...] Qualifier_id: $qualifier->id, Value: $value");
		}
	}
}