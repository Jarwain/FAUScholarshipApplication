<?php
require_once("models/Restriction.php");
require_once("models/Database.php");
	/*class Scholarships{
		var $scholarships;

		function __construct(){
			$db = new Database();
			$this->scholarships = $db->getScholarshipJoinRestriction();
		}
	}*/

	class Scholarship {
		var $code;
		var $name;
		var $description;
		var $active;
		var $counter;
		var $limit;
		
		var $restrictions;

		function __construct($code, $name, $description, $active, $counter, $limit){
			$this->code = $code;
			$this->name = $name;
			$this->description = $description;
			$this->active = $active;
			$this->counter = $counter;
			$this->limit = $limit;
			$this->restrictions = array();
		}

		public static function array_to_scholarship($arr){
			return new Scholarship($arr['code'],$arr['name'],$arr['description'],$arr['active'],$arr['counter'],$arr['limit']);
		}

		function printHTML(){
			echo "<div class='panel panel-default'>
			  <div class='panel-heading'>
			    <h3 class='panel-title'>$this->code ~ $this->name</h3>
			  </div>
			  <div class='panel-body'>
			    $this->description
			  </div>
			</div>";
		}
	}

?>