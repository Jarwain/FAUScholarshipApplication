<?php
	class Qualifiers {
		var $qualifiers;

		function __construct($qualifiers){
			if (is_array($qualifiers))
				$this->qualifiers = $qualifiers;
			else
				throw new Exception('Group of Qualifiers not an array');
		}

		function printFormGroups(){
			foreach($qualifiers as $q){
				$q->printInput();
			}
		}

		function areValid(){
			$db = new DataAccessor();
			$base = $db->getActiveQualifiers();

		}
	}

	class Qualifier {
		var $id;
		var $name;
		var $type;
		var $question;
		var $value;

		function __construct($id, $name, $type, $question, $value){
			$this->id = $id;
			$this->name = $name;
			$this->type = $type;
			$this->question = $question;
			$this->value = json_decode($value);
		}

		public static function array_to_qualifier($arr){
			return new Qualifier($arr['id'], $arr['name'], $arr['type'], $arr['question'], $arr['value']);
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
							print_r($this);
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
