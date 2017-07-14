<?php
	class ArrayOfQualifiers {
		var $qualifiers;

		function __construct($qualifiers){
			if (is_array($qualifiers))
				$this->qualifiers = $qualifiers;
			else
				throw new Exception('Group of Qualifiers not an array');
		}

		function printFormGroups(){
			foreach($this->qualifiers as $q){
				$q->printInput();
			}
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

	class Qualifier {
		var $id;
		var $name;
		var $type;
		var $question;
		var $value;
		var $param;

		function __construct($id, $name, $type, $question, $value, $param){
			$this->id = $id;
			$this->name = $name;
			$this->type = $type;
			$this->question = $question;
			$this->value = json_decode($value);
			$this->param = json_decode($param);
		}

		public static function array_to_qualifier($arr){
			return new Qualifier($arr['id'], $arr['name'], $arr['type'], $arr['question'], $arr['value'],$arr['param']);
		}

		public function printInput(){
			switch($this->type){
				case 1:
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
					break;
				case 2:
					echo "<div class='form-group'>
						<label for='$this->name' class='hidden-xs col-sm-2 control-label'>$this->question</label>
						<div class='col-xs-12 col-sm-3 col-sm-push-7'>
							<!-- Sidestuff -->
						</div>
						<div class='col-xs-12 col-sm-7 col-sm-pull-3'>
							<input  type='text' name='$this->id' id='$this->name' class='form-control' placeholder='$this->question'>
						</div>
					</div>";
					break;
				case 3:
					echo "<div class='form-group'>
						<label for='$this->name' class='hidden-xs col-sm-2 control-label'>$this->question</label>
						<div class='col-xs-12 col-sm-3 col-sm-push-7'>
							<!-- Sidestuff -->
						</div>
						<div class='col-xs-12 col-sm-7 col-sm-pull-3'>
							<select class='form-control' name='$this->id'>";
					foreach($this->value->param as $p){
						echo "<option value='$p'> $p </option>";
					}
					echo	"</select>
						</div>
					</div>";
					break;
				case 4:
					echo "<div class='form-group'>
						<label for='$this->name' class='hidden-xs col-sm-2 control-label'>$this->question</label>
						<div class='col-xs-12 col-sm-3 col-sm-push-7'>
							<!-- Sidestuff -->
						</div>
						<div class='col-xs-12 col-sm-7 col-sm-pull-3'>
							<select class='form-control' multiple name='$this->id'>";
					foreach($this->value->param as $p){
						echo "<option value='$p'> $p </option>";
					}
					echo	"</select>
						</div>
					</div>";
					break;
			}
		}
	}
?>
