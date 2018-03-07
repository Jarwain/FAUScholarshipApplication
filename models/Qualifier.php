<?php
require_once("Validate.php");

class ArrayOfQualifiers{
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

	function get($i) {
		return $this->qualifiers[$i];
	}

}

class QualifierFactory{

	public static function array_to_object($arr){
		switch($arr['type']){
			case 1:
				return new Bool($arr['id'], $arr['name'], $arr['question'], "['true','false']");
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
	// Checks validity 
	function isValid($value){
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
	use \Validate\Boolean;

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

	function printValue($param = NULL){
		if(is_null($param)){
			$param = $this->param;
		}

		$msg = "{$this->question} must be <strong>";
		if(count($param) == 1) $msg .= $param[0];
		else $msg .= implode("</strong> or <strong>", $param);

		return $msg."</strong>";
	}
}

class Range extends Qualifier{
	use \Validate\Range;

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

	function printValue($param = NULL){
		if(is_null($param)){
			$param = $this->param;
		}
		
		return "{$this->question} must be between <strong>{$param[0]} - {$param[1]}</strong>";
	}
}

class Single extends Qualifier{
	use \Validate\Single;

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

	function printValue($param = NULL){
		if(is_null($param)){
			$param = $this->param;
		}

		$msg = "{$this->question} must be ";
		$last = "<strong>".array_pop($param)."</strong>";
		switch(count($param)){
			case 0:
				$msg .= $last;
			break;
			case 1:
				$msg .= "either <strong>{$param[0]}</strong> or {$last}";
			break;
			default:
				$msg .= "either <strong>".implode("</strong>, <strong>", $param)."</strong>, or {$last}";
			break;
		}
		return $msg;
	}
}

class Multi extends Qualifier{
	use \Validate\Multi;

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

	function printValue($param = NULL){
		if(is_null($param)){
			$param = $this->param;
		}
		$msg = "{$this->question} must include ";
		$last = "<strong>".array_pop($param)."</strong>";
		switch(count($param)){
			case 0:
				$msg .= $last;
			break;
			case 1:
				$msg .= "either <strong>{$param[0]}</strong> or {$last}";
			break;
			default:
				$msg .= "either <strong>".implode("</strong>, <strong>", $param)."</strong>, or {$last}";
			break;
		}
		return $msg;
	}
}
?>
