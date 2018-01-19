<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);?>

<?php
require_once("../models/Scholarship.php");
require_once("../models/Student.php");
require_once("../models/Qualification.php");
require_once("../util/JS.php");
// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');

// Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');
session_start();

try{
	if(!isset($_SESSION['qualifiers'])){
		$db = new DataAccessor();
		$_SESSION['qualifiers'] = $db->getActiveQualifiers();
	}
	// Validate submitted qualifications
	$qualifications = new ArrayOfQualifications($_SESSION['qualifiers'], $_GET);

	$student = Student::Factory("Z12345678", $qualifications);
	// if($student == NULL) throw new Exception("Student is false!");
	$searchResults = $db->getScholarshipsJoinRestriction()->search($student);
} catch (\PDOException $ex){
	JS::console_log("There was a PDOexception in PHP: ",$ex->getMessage());
} catch (Exception $ex){
	JS::console_log("There was an exception in PHP: ",trim($ex->getMessage()));
}

?>
<?php include "header.php" ?>
	<div class="page-header">
		<img src="img/CENTYPECL.jpg" class="center-block">
		<h1>Financial Aid <small>Scholarship Search</small></h1>
	</div>
	<h2>Qualifying Scholarships:</h2>
	<p>Fill out as much as you can</p>
	<h3 class="bg-info text-center">Part 1: Qualifications</h3>
	<?php

	// $searchResults = null;

	
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
					$searchResults['valid']->printHTML();
					/*foreach($searchResults['valid'] as $sch){
						$sch->printHTML();
					}*/
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
				$searchResults['invalid']->printHTML();
				?>
				</div>
			</div>
		</div>
	</div>

<?php include "footer.php" ?>