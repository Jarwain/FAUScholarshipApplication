<?php
require_once("Validatable.php");

class ArrayOfQualifiers {
	var $qualifiers = array();

	function __construct($qualifiers){
		if (is_array($qualifiers)){
			$this->qualifiers = array_reduce($qualifiers, function($carry, $item){
				$carry[$item->id] = $item;
				return $carry;
			});
		}
		else
			throw new Exception('Group of Qualifiers not an array');
	}

	function printValueFormGroups(){
		foreach($this->qualifiers as $q){
			$q->printValueInput();
		}
	}

	function get(/*integer */$i) {
		return $this->qualifiers[$i];
	}

	// Expects $qualifications == array(Qualifier_id=>submitted_value)
	// Returns $this array if valid
	// else returns array of errors
	function validate($qualifications){
		$err = null;
		foreach($qualifications as $key=>$val){
			$result = array(
				"status" => "OK",
				"object" => "meh"
			);
			if($key == 's') continue;
			
			$res = $this->qualifiers[$key]->isValid($val);
			if($res)
				$this->qualifiers[$key]->value = $val;
			else
				array_push($res);
		}
		return $totRes;
		JS::console_log(print_r($this->qualifiers,true));			

		// TODO: do the rest of validation
	}

	function areValid(){
		$db = new DataAccessor();
		$base = $db->getActiveQualifiers()->qualifiers; 
		// Get Qualifiers, related questions, and validation parameters
		// TODO: REFACTOR QUALIFIER TABLE
		foreach($this->qualifiers as $key=>$val){
			if(array_key_exists($key,$base)){

				switch($base[$key]->type){
					case 1:
						if($val === 'true' || $val === 'false'){
							$base[$key]->value =
								$val === 'true' ? true : false;
						} else { return false; }
						break;
					case 2:
						$param = $base[$key]->param;
						$num = floatval($val);
						if($num >= $param[0] && $num <= $param[1]){
							$base[$key]->value = $val;
						}	else { return false; }
						break;
					case 3:
						$param = $base[$key]->param;
						if(in_array($val,$param)){
							$base[$key]->value = $val;
						} else { return false; }
						break;
					case 4:
						$param = $base[$key]->param;
						break;
				}
			}
		}
		return $base;

	}
}

class QualifierFactory{

	public static function array_to_object($arr){
		switch($arr['type']){
			case 1:
				return new Bool($arr['id'], $arr['name'], $arr['question'], $arr['param']);
				break;
			case 2:
				return new Range($arr['id'], $arr['name'], $arr['question'], $arr['param']);
				break;
			case 3:
				return new Single($arr['id'], $arr['name'], $arr['question'], $arr['param']);
				break;
			case 4:
				return new Multi($arr['id'], $arr['name'], $arr['question'], $arr['param']);
				break;
		}
	}
}

abstract class Qualifier {
	var $id;
	var $name;
	var $question;
	var $param;

	// Print HTML input field
	abstract public function printValueInput();
	// Checks 
	//abstract public function isValid($base);
	function isValid($value){
		if(is_null($this->param))
			return $this->validate($value);
		return $this->validate($value, $this->param);
	}

	function __construct($id, $name, $question, $param){
		$this->id = $id;
		$this->name = $name;
		$this->question = $question;
		$this->param = json_decode($param);
	}


}

class Bool extends Qualifier{
	function printValueInput(){
		echo "<div class='form-group'>
			<label for='$this->name' class='hidden-xs col-sm-2 control-label'>$this->question</label>
			<div class='col-xs-12 col-sm-3 col-sm-push-7'>

			</div>
			<div class='col-xs-12 col-sm-7 col-sm-pull-3'>
				<label class='radio-inline'>
					<input type='radio' name='$this->id' value='true'> Yes
				</label>
				<label class='radio-inline'>
					<input type='radio' name='$this->id' value='false'> No
				</label>
			</div>
		</div>";
	}

	use ValidateBoolean;
}
class Range extends Qualifier{
	function printValueInput(){
		echo "<div class='form-group'>
			<label for='$this->name' class='hidden-xs col-sm-2 control-label'>$this->question</label>
			<div class='col-xs-12 col-sm-3 col-sm-push-7'>
				<!-- Sidestuff -->
			</div>
			<div class='col-xs-12 col-sm-7 col-sm-pull-3'>
				<input  type='text' name='$this->id' id='$this->name' class='form-control' placeholder='$this->question'>
			</div>
		</div>";
	}
	use ValidateRange;
	
}
class Single extends Qualifier{
	function printValueInput(){
		echo "<div class='form-group'>
			<label for='$this->name' class='hidden-xs col-sm-2 control-label'>$this->question</label>
			<div class='col-xs-12 col-sm-3 col-sm-push-7'>
				<!-- Sidestuff -->
			</div>
			<div class='col-xs-12 col-sm-7 col-sm-pull-3'>
				<select class='form-control' name='$this->id'>";
		foreach($this->param as $p){
			echo "<option value='$p'> $p </option>";
		}
		echo	"</select>
			</div>
		</div>";
	}

	use ValidateSingle;
	/*function isValid($value){
		return $this->validate($value, $this->param);
	}*/
}
class Multi extends Qualifier{
	function printValueInput(){
		echo "<div class='form-group'>
			<label for='$this->name' class='hidden-xs col-sm-2 control-label'>$this->question</label>
			<div class='col-xs-12 col-sm-3 col-sm-push-7'>
				<!-- Sidestuff -->
			</div>
			<div class='col-xs-12 col-sm-7 col-sm-pull-3'>
				<select class='form-control' multiple name='$this->id'>";
		foreach($this->param as $p){
			echo "<option value='$p'> $p </option>";
		}
		echo	"</select>
			</div>
		</div>";
	}

	use ValidateMulti;
	/*function isValid($value){
		return $this->validate($value, $this->param);
	}*/
}
?>
