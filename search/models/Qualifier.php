<?php
	class Qualifier
	{
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

		public static function getQualifiers(){
			try{
				$settings = json_decode(file_get_contents(__DIR__ . "/../.config/database"));
				$link = new \PDO( 'mysql:host='.$settings->host.';dbname='.$settings->dbname.';charset=utf8mb4',
					$settings->user,
					$settings->pass,
					array(
						\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
						\PDO::ATTR_PERSISTENT => false
					)
				);
			
				$dbQualifiers = $link->query("SELECT `id`,`name`,`type`,`question`,`value` FROM `qualifier`")->fetchAll();
				$qualifiers = array_map('Qualifier::array_to_qualifier', $dbQualifiers);
				$qualifiers = array_reduce($qualifiers,function($carry, $item){
					//$carry[$item->id] = $item;
					$carry[$item->name] = $item;
					return $carry;
				}, array());
				return $qualifiers;
			} catch (Exception $ex){
				throw $ex;
			}
		}

		public static function getActiveQualifiers(){
			try{
				$settings = json_decode(file_get_contents(__DIR__ . "/../.config/database"));
				$link = new \PDO( 'mysql:host='.$settings->host.';dbname='.$settings->dbname.';charset=utf8mb4',
					$settings->user,
					$settings->pass,
					array(
						\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
						\PDO::ATTR_PERSISTENT => false
					)
				);
			
				$dbQualifiers = $link->query("SELECT q.`id`,q.`name`,q.`type`,q.`question`,q.`value` FROM `restriction` r 
					JOIN `qualifier` q ON q.`id`=r.`qualifier_id`
					GROUP BY `qualifier_id`")->fetchAll();
				$qualifiers = array_map('Qualifier::array_to_qualifier', $dbQualifiers);
				$qualifiers = array_reduce($qualifiers,function($carry, $item){
					//$carry[$item->id] = $item;
					$carry[$item->name] = $item;
					return $carry;
				}, array());
				return $qualifiers;
			} catch (Exception $ex){
				throw $ex;
			}	
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
								<input type='radio' name='$this->name' value='true'> Yes
							</label>
							<label class='radio-inline'>
								<input type='radio' name='$this->name' value='false'> No
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
							<input  type='text' name='$this->name' id='$this->name' class='form-control' placeholder='$this->question'>
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
							<select class='form-control' name='$this->name'>";
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
							<select class='form-control' multiple name='$this->name'>";
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
