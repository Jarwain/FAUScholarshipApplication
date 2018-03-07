<?php
require_once("Requirement.php");
require_once("DataAccessor.php");
class ArrayOfScholarships{
	var $scholarships;

	function __construct($scholarships){
		$this->scholarships = $scholarships;
	}

  function asJSON(){

  }

	function printHTML(){
		foreach($this->scholarships as $sch){
			$sch->printHTML();
		}
	}

	function printWithStudent($student){
		foreach($this->scholarships as $sch){
			$sch->printWithStudent($student);
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
	
	var $requirements;

	function __construct($code, $name, $description, $active, $counter, $limit, $requirements = null){
		$this->code = $code;
		$this->name = $name;
		$this->description = $description;
		$this->active = $active;
		$this->counter = $counter;
		$this->limit = $limit;
		$this->requirements = $requirements;
	}

	public static function array_to_scholarship($arr){
		return new Scholarship($arr['code'],$arr['name'],$arr['description'],$arr['active'],$arr['counter'],$arr['limit']);
	}

  function asJSON(){
    return json_encode($this);
  }

		// Strips the wildcard by adding it to all conditions (when relevant)
	function condensedRequirements(){
		if(count($this->requirements) > 1 && array_key_exists('*', $this->requirements)){
			$requirementSets = $this->requirements;
			$wildcard = $requirementSets['*'];
			unset($requirementSets['*']);
			$results = [];
			foreach ($requirementSets as $cat => $reqs) {
				foreach ($wildcard as $key => $value) {
					$reqs[$key] = $value;
				}
				$results[$cat] = $reqs;
			}
			return $results;
		}
		return $this->requirements;
	}

	function printRequirementCatHTML($qualifiers, $requirements, $student = NULL){
		$out = "";
		if(!is_null($student)){
			$out .= "
			<table class='table'>
				<thead>
					<tr>
						<th>Requirements</th>
						<th>You Put</th>
					</tr>
				</thead>
				<tbody>";

			foreach($requirements as $id => $req){
				$color = $qualifiers->get($id)->validate($student->qualifications[$id], $req->getParam())->res ? 'success' : 'danger';
				$out .= "
					<tr class='{$color}'>";
				$out .= "<td>".$qualifiers->get($id)->printValue($req->getParam())."</td>";
				$out .= "<td>".$student->qualifications[$id]."</td>";
				$out .= "
					</tr>";
			}
			$out .= "
				</tbody>
			</table>";
		} else {			
			foreach($requirements as $id => $req){
				$out .= $qualifiers->get($id)->printValue($req->getParam());
				$out .= "<br />";
			}
		}

		return $out;
	}

	function printHTML($qualifiers = NULL, $student = NULL){
		$output = "
		<div class='panel panel-default'>
			<div class='panel-heading'>
				<h3 class='panel-title'>
					{$this->code} ~ {$this->name}
					<a href='/scholarship_app/?scholarship={$this->code}' class='pull-right'><u>Apply Now!</u></a>
				</h3>
			</div>";

		if(is_null($qualifiers)){
			$output .= "
			<div class='panel-body'>
				{$this->description}
			</div>
		</div>";
		} else {
			$requirements = $this->condensedRequirements();
			$output .= "
			<div class='panel-body row'>
				<div class='col-sm-8'>
					{$this->description}
				</div>
				<div class='col-sm-4'>";
			if(count($requirements) > 1){
				$output .= "
					<ul class='nav nav-tabs' role='tablist'>";
				$keys = array_keys($requirements);
				$active = "active";
				foreach ($keys as $key) {
					$output .= "
						<li role='presentation' class='{$active}'><a href='#{$key}_{$this->code}' aria-controls='{$key}' role='tab' data-toggle='tab'>{$key}</a></li>";
					$active = "";
				}
				$output .= "
					</ul>";
				$output .= "
					<div class='tab-content'>";
				$active = "active";
				foreach($requirements as $cat => $reqs){
					$output .= "<div role='tabpanel' class='tab-pane {$active}' id='{$cat}_{$this->code}'>";
					$output .= $this->printRequirementCatHTML($qualifiers, $reqs, $student);
					$output .= "</div>";
					$active = "";
				}
				$output .= "
					</div>";
			} else {
				$output .= "
					<div class='panel panel-default'>
						<div class='panel-body'>";
				if(!is_null($requirements) && array_key_exists('*', $requirements)){
					$output .= $this->printRequirementCatHTML($qualifiers, $requirements['*'], $student);
				} else {
					$output .= "Any FAU Student may apply.";
				}
				$output .= "
						</div>
					</div>";
						
			}
			$output .= "
				</div>
			</div>";
		}
		$output .= "
		</div>";

		return $output;
	}

	function altprintHTML($qualifiers = NULL, $student = NULL){
		$output = "";
		if(is_null($qualifiers)){ // If it is not printing requirements
			$output = "
		<div class='panel panel-default'>
			<div class='panel-heading'>
				<h3 class='panel-title'>{$this->code} ~ {$this->name}</h3>
			</div>
			<div class='panel-body'>
				{$this->description}
			</div>
		</div>";
		} else if(!is_null($qualifiers)){ // If it is printing requirements
			$output = "
		<div class='row'>
		<div class='col-sm-8 pad-r'>
		<div class='panel panel-default'>
			<div class='panel-heading'>
				<h3 class='panel-title'>{$this->code} ~ {$this->name}</h3>
			</div>
			<div class='panel-body'>
				{$this->description}
			</div>
		</div>
		</div>";
			$output .= "
		<div class='col-sm-4 pad-l'>
		<div class='panel panel-default'>
			<div class='panel-heading'>
				<h3 class='panel-title'>Requirements</h3>
			</div>
			<div class='panel-body'>";

			$requirements = $this->condensedRequirements();
			if(count($requirements) > 1){
				$output .= "
				<ul class='nav nav-tabs' role='tablist'>";
				$keys = array_keys($requirements);
				$active = "active";
				foreach ($keys as $key) {
					$output .= "
					<li role='presentation' class='{$active}'><a href='#{$key}_{$this->code}' aria-controls='{$key}' role='tab' data-toggle='tab'>{$key}</a></li>";
					$active = "";
				}
				$output .= "
				</ul>";
				$output .= "
				<div class='tab-content'>";
				$active = "active";
				foreach($requirements as $cat => $reqs){
					$output .= "<div role='tabpanel' class='tab-pane {$active}' id='{$cat}_{$this->code}'>";
					$output .= $this->printRequirementCatHTML($qualifiers, $reqs, $student);
					$output .= "</div>";
					$active = "";
				}
				$output .= "
				</div>";
			} else {
				if(!is_null($requirements) && array_key_exists('*', $requirements)){
					$output .= $this->printRequirementCatHTML($qualifiers, $requirements['*'], $student);
				} else {
					$output .= "Any FAU Student may apply.";
				}	
			}
		$output .= "
			</div>
		</div>
		</div>
		</div>";
		}

		return $output;
	}
}

?>