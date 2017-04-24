<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);?>

<?php
require_once("models/Qualifier.php");
// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');

// Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');
session_start();

?>

<!DOCTYPE HTML>
<html lang="en" class="no-js">
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title>FAU Scholarship Application</title>

		<!-- Bootstrap -->
		<!--link href="css/bootstrap.min.css" rel="stylesheet"-->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">


		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<![endif]-->

		<style>
			form.form-horizontal{
				margin-top: 1.5em;
			}
			html.no-js #main{
				display:none;
			}
			html {
				position: relative;
				min-height: 100%;
			}
			body {
				/* Margin bottom by footer height */
				margin-bottom: 60px;
			}
			.container .text-muted {
				margin: 20px 0;
			}
			.btn + .btn {
				margin-left: 10px;
			}
			p.bg-warning{
				padding: 10px;
			}
			img{
				max-width: 269px;

			}
			#footer {
				position: absolute;
				bottom: 0;
				width: 100%;
				/* Set the fixed height of the footer here */
				height: 60px;
				background-color: #f5f5f5;
			}
		</style>

			</head>
	<body>
		<noscript>
			This Form requires JavaScript to be properly submitted. Please enable javascript, then refresh the page.
			Javascript is only being used for basic form validation
		</noscript>
		<div class="container" id="main">
			<div class="page-header">
				<img src="img/CENTYPECL.jpg" class="center-block">
				<h1>Financial Aid <small>Scholarship Search</small></h1>
			</div>
			<h2>Student Information</h2>
			<p>Fill out as much as you can</p>
			<h3 class="bg-info text-center">Part 1: Qualifications</h3>
			<form class="form-horizontal" role="form" action="search.php" method="post">
				<input type="hidden" name="submitted" value="true">
				<?php
					try{
						print_r(qualifier::getQualifiers());
					} catch (\PDOException $ex){
						echo $ex->getMessage();
						 echo "<script>console.log(\"There was an Exception in PhP. ".$ex->getMessage()."\")</script>";
					} catch (Exception $ex){
						echo $ex->getMessage();
						 echo "<script>console.log(\"There was an Exception in PhP. ".trim($ex->getMessage())."\")</script>";
					}
				?>
				<div class="form-group">
					<label for="gpa" class="hidden-xs col-sm-2 control-label">GPA</label>
					<div class="col-xs-12 col-sm-3 col-sm-push-7">

					</div>
					<div class="col-xs-12 col-sm-7 col-sm-pull-3">
						<input  type="text" name="gpa" id="gpa" class="form-control" placeholder="GPA">
					</div>
				</div>

				<!--div class="form-group">
					<label for="area_of_study" class="hidden-xs col-sm-2 control-label">Area of Study</label>
					<div class="col-xs-12 col-sm-3 col-sm-push-7">

					</div>
					<div class="col-xs-12 col-sm-7 col-sm-pull-3">
						<input  type="text" name="area_of_study" id="area_of_study" class="form-control" placeholder="Area of Study">
					</div>
				</div>

				<div class="form-group">
					<label for="college" class="hidden-xs col-sm-2 control-label">College</label>
					<div class="col-xs-12 col-sm-3 col-sm-push-7">

					</div>
					<div class="col-xs-12 col-sm-7 col-sm-pull-3">
						<input  type="text" name="college" id="college" class="form-control" placeholder="Engineering, Education,...">
					</div>
				</div-->

				<div class="form-group">
					<label for="fafsa" class="hidden-xs col-sm-2 control-label">Completed FAFSA</label>
					<div class="col-xs-12 col-sm-3 col-sm-push-7">

					</div>
					<div class="col-xs-12 col-sm-7 col-sm-pull-3">
						<label class="radio-inline">
							<input type="radio" name="fafsa" value="true"> Yes
						</label>
						<label class="radio-inline">
							<input type="radio" name="fafsa" value="false"> No
						</label>
					</div>
				</div>

				<!--div class="form-group">
					<label for="standing" class="hidden-xs col-sm-2 control-label">University Standing</label>
					<div class="col-xs-12 col-sm-3 col-sm-push-7">

					</div>
					<div class="col-xs-12 col-sm-7 col-sm-pull-3">
						<input  type="text" name="standing" id="standing" class="form-control" placeholder="University Standing">
					</div>
				</div-->

				<div class="form-group">
					<label for="year" class="hidden-xs col-sm-2 control-label">Year</label>
					<div class="col-xs-12 col-sm-3 col-sm-push-7">

					</div>
					<div class="col-xs-12 col-sm-7 col-sm-pull-3">
						<input  type="text" name="year" id="year" class="form-control" placeholder="Freshman, Sophomore, Junior, Senior, Graduate">
					</div>
				</div>

				<!--div class="form-group">
					<label for="credits" class="hidden-xs col-sm-2 control-label"># of Credits Currently Taking</label>
					<div class="col-xs-12 col-sm-3 col-sm-push-7">

					</div>
					<div class="col-xs-12 col-sm-7 col-sm-pull-3">
						<input  type="text" name="credits" id="credits" class="form-control" placeholder="1-18">
					</div>
				</div-->

				<div class="form-group">
					<label for="need" class="hidden-xs col-sm-2 control-label">Do you Qualify for Financial Need?</label>
					<div class="col-xs-12 col-sm-3 col-sm-push-7">

					</div>
					<div class="col-xs-12 col-sm-7 col-sm-pull-3">
						<label class="radio-inline">
							<input type="radio" name="need" value="true"> Yes
						</label>
						<label class="radio-inline">
							<input type="radio" name="need" value="false"> No
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary">Continue</button>
					</div>
				</div>
			</form>
	</div> <!-- ./container -->
		<div id="footer">
			<div class="container">
				<p class="text-muted">Copyright © 2015-2016 FAU Office of Student Financial Aid. All rights reserved.</p>
			</div>
		</div>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/additional-methods.min.js"></script>
		<script src="js/validate.js"></script>
		<script type="text/javascript">
			$('html').removeClass('no-js').addClass('js'); // This is used to determine if Javascript is enabled
		</script>    <script type="text/javascript">
					</script>
	</body>
</html>