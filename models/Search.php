<?php
class Search {
	var $qualifiers;

	var $results;

	function __construct($qualifiers = NULL){
		$db = new DataAccessor();
		if(is_null($qualifiers)){
			$qualifiers = $db->getActiveQualifiers();
		}

		$this->qualifiers = $qualifiers;
	}

	function scholarships($student){
		$db = new DataAccessor();
		$scholarships = $db->getScholarshipsJoinRequirements()->scholarships;

		$result = array('valid' => array(), 'invalid' => array());
		foreach($scholarships as $code => $scholarship) {
			$report = $student->qualifiesFor($scholarship, $this->qualifiers);
			if($report[0]){
				$result['valid'][$code] = $scholarship;
			} else {
				$result['invalid'][$code] = $scholarship;
			}
			$result['reports'][$code] = $report;

		}
		$this->results = $result;

		/*$result['valid'] = new ArrayOfScholarships($result['valid']);
		$result['invalid'] = new ArrayOfScholarships($result['invalid']);*/
		return $result;
	}

	function printHTML($case, $student = NULL){
		$qualifiers = $this->qualifiers;
		$output = "";

		foreach ($this->results[$case] as $code => $sch) {
			$output .= $sch->printHTML($qualifiers, $student);
		}
		return $output;
	}
}
?>