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
				$qualifiers = array_reduce(function($carry, $item){
					$carry[name] = $item;
					return $carry;
				},
				$qualifiers,array());
				return $qualifiers;
			} catch (Exception $ex){
				throw $ex;
			}
		}

		public function render(){
			echo '<div class="form-group">
			<label for="'.$this->name.'" class="hidden-xs col-sm-2 control-label">'.$this->question.'</label>
			<div class="col-xs-12 col-sm-3 col-sm-push-7">
			<!-- Sidestuff -->
			</div>
			<div class="col-xs-12 col-sm-7 col-sm-pull-3">';

			//	<input  type="text" name="gpa" id="gpa" class="form-control" placeholder="GPA">
			echo '</div></div>';
		}
	}
?>
