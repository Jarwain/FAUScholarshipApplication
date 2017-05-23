<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);?>
<?php
require_once("models/Scholarship.php");
require_once("models/Student.php");
require_once("JS.php");
// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');

// Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');
session_start();
// If Session vars haven't been established, assign them
if(isset($_POST['submitted'])){
/*	$_SESSION['student']['fafsa'] = $_POST['fafsa'];
	$_SESSION['student']['need'] = $_POST['need'];
	$_SESSION['student']['gpa'] = $_POST['gpa'];
	$_SESSION['student']['year'] = $_POST['year'];*/
} else {
	header("location: index.php");
}
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
			<h2>Qualifying Scholarships:</h2>
			<p>Fill out as much as you can</p>
			<h3 class="bg-info text-center">Part 1: Qualifications</h3>
			<?php
			try{
				$student = Student::studentFactory("Z12345678",$_POST);
				$scholarships = Scholarship::getScholarshipsRestrictions();
				foreach($scholarships as $scholarship)
				{
					if(count($scholarship->restrictions) == 0){
						$valid[] = $scholarship;
						continue;
					} else if (array_key_exists('*', $scholarship->restrictions)){
						if($student->isQualified($scholarship->restrictions['*'])){
							//unset($scholarship->restrictions['*']);
							if(count($scholarship->restrictions) == 1){
								$valid[] = $scholarship;
								continue;
							}
							foreach($scholarship->restrictions as $restriction){
								if($restriction->category != '*' && $student->isQualified($restriction)){
									$valid[] = $scholarship;
									break;
								}
							}
						}
						continue;
					} else {
						foreach($scholarship->restrictions as $restriction){
							if($student->isQualified($restriction)){
								$valid[] = $scholarship;
								break;
							}
						}
					}
				}
				JS::print(json_encode($student));
				JS::print(json_encode($valid));
				// TODO: Filter $scholarships by student data
			} catch (\PDOException $ex){
				JS::print("There was an exception in PHP: ",$ex->getMessage());
			} catch (Exception $ex){
				JS::print("There was an exception in PHP: ",trim($ex->getMessage()));
			}
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
							foreach($valid as $sch){
								$sch->print();
							}
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
							Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
						</div>
					</div>
				</div>
			</div>

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