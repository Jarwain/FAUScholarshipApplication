<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);?>

<?php
require_once("../models/Qualifier.php");
require_once("../models/DataAccessor.php");
require_once("../util/JS.php");
// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');

// Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');
session_start();

?>
<?php include "header.php" ?>
	<div class="page-header">
		<img src="img/CENTYPECL.jpg" class="center-block">
		<h1>Financial Aid <small>Scholarship Search</small></h1>
	</div>
	<h2>Student Information</h2>
	<p>Fill out as much as you can</p>
	<h3 class="bg-info text-center">Part 1: Qualifications</h3>
	<form class="form-horizontal" role="form" action="search.php" method="get">
		<input type="hidden" name="s" value="1">
		<?php
			try{
				$db = new DataAccessor();
				$qualifiers = $db->getActiveQualifiers();
				$qualifiers->printFormGroups();
			} catch (Exception $ex){
				JS::console_log("There was an exception in PHP: ",trim($ex->getMessage()));
			}
		?>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Continue</button>
			</div>
		</div>
	</form>
<?php include "footer.php" ?>