<?php
require_once("../models/Restriction.php");
require_once("../models/DataAccessor.php");
	class ArrayOfScholarships{
		var $scholarships;

		function __construct($scholarships){
			$this->scholarships = $scholarships;
		}

		function search($student){
			JS::console_log(print_r($this->scholarships,true));
			$result = array('valid' => array(), 'invalid' => array());
			foreach($this->scholarships as $scholarship) {
				$restriction_categories = $scholarship->restrictions;
				if(count($restriction_categories) == 0){
					$result['valid'][] = $scholarship;
					continue;
				} else if (array_key_exists('*', $restriction_categories)){
					if($student->isQualified($restriction_categories['*'])){
						unset($restriction_categories['*']);
						if(count($restriction_categories) == 0){
							$result['valid'][] = $scholarship;
							continue;
						}
						foreach($restriction_categories as $category){
							if($student->isQualified($category)){
								$result['valid'][] = $scholarship;
								break;
							}
						}
					}
					//continue;
				} else {
					foreach($restriction_categories as $category){
						if($student->isQualified($category)){
							$result['valid'][] = $scholarship;
							break;
						}
					}
				}
				$result['invalid'][] = $scholarship;

			}
			$result['valid'] = new ArrayOfScholarships($result['valid']);
			$result['invalid'] = new ArrayOfScholarships($result['invalid']);
			return $result;
		}

		function printHTML(){
			foreach($this->scholarships as $sch){
				$sch->printHTML();
			}
		}
	}

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