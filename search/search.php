<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);?>

<?php
require_once("../models/Search.php");
require_once("../models/Scholarship.php");
require_once("../models/Student.php");
require_once("../views/HTML.php");
require_once("../util/JS.php");
// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');

// Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');
session_start();

try{
	if(!isset($_SESSION['qualifiers']) || is_null($_SESSION['qualifiers'])){
		$db = new DataAccessor();
		$_SESSION['qualifiers'] = $db->getActiveQualifiers();
	}
	$student = Student::ValidatingFactory("Z12345678", $_GET, $_SESSION['qualifiers']);

	// Validates submitted values. If invalid, errors are thrown
	if(is_array($student)){
		$err = $student['errors'];
		$student = $student['student'];
		throw new Exception("VALIDATION ERROR: ".json_encode($err), 1);
	}

	$search = new Search($_SESSION['qualifiers']);
	$search->scholarships($student);

} catch (Exception $ex){
	JS::console_log("EXCEPTION [PHP] ", trim($ex->getMessage()));
}

?>
<?php include "header.php" ?>
<style type="text/css">
	.tab-pane {
		border: 1px solid #ddd;
    	border-top-color: transparent;
    	padding: 15px;
	}

	.panel-body > .row {
		padding-top: 10px;
		padding-bottom: 10px;
		display: flex;
	}

	.pad-r {
		padding-right: 7.5px;
	}
	.pad-l {
		padding-left: 7.5px;
	}
</style>
	<div class="page-header">
		<img src="img/CENTYPECL.jpg" class="center-block">
		<h1>Financial Aid <small>Scholarship Search</small></h1>
	</div>
	<h2>Qualifying Scholarships:</h2>
	<p>Fill out as much as you can</p>
	<h3 class="bg-info text-center">Part 1: Qualifications</h3>
	<?php

	// $results = null;

	
	?>
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-success">
			<div class="panel-heading" role="tab" id="headingOne">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Qualified Scholarships
					</a>
				</h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body">
					<?php
					echo $search->printHTML('valid', $student);
					?>
				</div>
			</div>
		</div>
		<div class="panel panel-danger">
			<div class="panel-heading" role="tab" id="headingTwo">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						Unqualified Scholarships
					</a>
				</h4>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				<div class="panel-body">
					<?php
					echo $search->printHTML('invalid', $student);
					?>
				</div>
			</div>
		</div>
	</div>

<?php include "footer.php" ?>