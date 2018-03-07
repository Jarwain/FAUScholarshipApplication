<?php
class HTML{
	static function printSearchResults($results, $qualifiers = NULL, $reports = NULL){
		$output = "";
		foreach ($results as $code => $sch) {
			$output .= $sch->printHTML($qualifiers);
		}
		return $output;
	}
}
?>