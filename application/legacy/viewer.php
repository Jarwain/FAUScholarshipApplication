<?php
// $_GET['submit']
// null = not submitted
// 1 = submitted request for applications
// 2 = Attempted to Log in

// $_SESSION['admin']
// 0 = not authenticated at all
// 1 = Partial auth
// 2 = admin auth

// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');

// Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');
session_start();

if(empty($_SESSION['admin'])){
    $_SESSION['admin'] = 0;  
}
if($_POST['permission'] == "fancyaid"){
	$_SESSION['admin'] = 1;
}


$error = "";
$_SESSION['znumber'] = NULL;    
$_SESSION['scholarship'] = NULL;

if(empty($_SESSION['admin'])){
    $_SESSION['admin'] = 0;  
}

if(!empty($_GET['logout']) && $_GET['logout'] == 1){
    session_destroy();
    header("location: viewer.php");
    exit;
}

// Include connection Settings
try{
    //include "settings.php";   
    $host = "localhost";
	$user = "schapp";
	$pass = "schapp";
	$dbname = "scholarship_applications_1718";
    // Create a new connection.
    // \PDO::ATTR_ERRMODE enables exceptions for errors.  This is optional but can be handy.
    // \PDO::ATTR_PERSISTENT disables persistent connections, which can cause concurrency issues in certain cases.  
    $link = new \PDO( 'mysql:host='.$host.';dbname='.$dbname.';charset=utf8mb4', 
    $user, 
    $pass, 
    array(
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, 
        \PDO::ATTR_PERSISTENT => false
        )
    );
} catch (\PDOException $ex){
    $error .= $ex->getMessage()."<br />";
} catch (Exception $ex){
    $error .= $ex->getMessage()."<br />";
}

// Admin Login
if(isset($_GET['submit']) && $_GET['submit'] == 2 && !empty($_POST['username']) && !empty($_POST['password'])){
    $credentialSELECT = $link ->prepare(" SELECT `pass` FROM `login` 
    WHERE `user` = :user");
    $credentialSELECT->bindValue(':user',$_POST['username'], \PDO::PARAM_STR);
    $credentialSELECT->execute();
    $userPassword = $credentialSELECT->fetchALL(PDO::FETCH_COLUMN,0);
    if(!empty($userPassword[0]) && crypt($_POST['password'], $userPassword[0]) == $userPassword[0]){
        $_SESSION['admin'] = 2;
        $_SESSION['user'] = $_POST['username'];
        //header("Location: viewer.php");
    } else {
        $error.="Invalid Username/Password.<br />";
    }
}

// Session time-out handling
// If Last request was more than 30 minutes ago, kill session // 1800 seconds = 30 minutes
if($_SESSION['admin'] >= 1){
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
        header("location: viewer.php");
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp


    // session started more than 30 minutes ago
    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } else 
    if (time() - $_SESSION['CREATED'] > 30) {
        session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
        $_SESSION['CREATED'] = time();  // update creation time
    }
}

// Grab Applications From Database
if(isset($_GET['submit']) && $_GET['submit'] == 1){
    if(isset($_GET['znumber']) && mb_strlen($_GET['znumber']) == 9 && preg_match("/^Z\d{8}$/i", $_GET['znumber']) == true){
        $_SESSION['znumber'] = $_GET['znumber'];
    } else 
    if(empty($_GET['znumber'])){
        if(!empty($_GET['firstname']) && !empty($_GET['lastname'])){
            // If there's no znumber, use student name if available  
            $nameSELECT = $link->prepare("SELECT `znumber` FROM `student` 
            WHERE `firstname` = :firstname AND
            `lastname`  = :lastname");
            $nameSELECT->bindValue(':firstname',$_GET['firstname'], \PDO::PARAM_STR);
            $nameSELECT->bindValue(':lastname',$_GET['lastname'], \PDO::PARAM_STR);
            $nameSELECT->execute();
            $_SESSION['znumber'] = $nameSELECT->fetchAll(PDO::FETCH_COLUMN, 0)[0];
        } else {
            $_SESSION['znumber'] = NULL;
        }
    } else {
        $error .= "Invalid zNumber <br />";
    }
    if(isset($_GET['scholarship'])){
        if (strcmp($_GET['scholarship'],"any") == 0){
            $_SESSION['scholarship'] = NULL;
        } else{
            $_SESSION['scholarship'] = $_GET['scholarship'];
        }
    } else{
        $error .= "There's no Scholarship Code... What? <br />";
    }
    try{
        if(isset($_GET['submit']) && $_GET['submit'] == 1){
            if($_SESSION['znumber'] == NULL){
                if($_SESSION['scholarship'] == NULL){
                    // If no znumber and no scholarship, grab a random application
                    // Generate a random row to work with
                    $countSELECT = $link->prepare("SELECT COUNT(*) AS cnt FROM `student_scholarship`");
                    $countSELECT->execute();
                    $count = rand(1,$countSELECT->fetchAll()[0]['cnt']);

                    $applicationSELECT = $link->prepare("SELECT ST.`gpa`,ST.`year`,ST.`school`,ST.`major`,A.`response`,A.`summary`,A.`submitted`,S.`znumber`,S.`code`,S.`accepted`,S.`ranking`,S.`note`,B.`question`,B.`type`,C.`name`,C.`description`,C.`counter`,C.`limit`,F.`id`,F.`name` as `fname` 
                        FROM `answer` A
                        INNER JOIN `question` B ON B.`id` = A.`question_id`
                        INNER JOIN `student_scholarship` S on S.`id` = A.`stu_schID`
                        INNER JOIN `scholarship` C ON C.`code` = S.`code`
                        INNER JOIN `student` ST ON ST.`znumber` = S.`znumber`
                        LEFT JOIN `file` F ON f.`id` = A.`response`
                        WHERE S.`id` = :count");
                    $applicationSELECT->bindValue(':count', $count, \PDO::PARAM_INT);
                    $applicationSELECT->execute();
                } else {
                    // If no znumber and scholarship, grab a all applications for the given scholarship
                    $applicationSELECT = $link->prepare("SELECT ST.`gpa`,ST.`year`,ST.`school`,ST.`major`,A.`response`,A.`summary`,A.`submitted`,S.`znumber`,S.`code`,S.`accepted`,S.`ranking`,S.`note`,B.`question`,B.`type`,C.`name`,C.`description`,C.`counter`,C.`limit`,F.`id`,F.`name` as `fname` 
                        FROM `answer` A
                        INNER JOIN `question` B ON B.`id` = A.`question_id`
                        INNER JOIN `student_scholarship` S on S.`id` = A.`stu_schID`
                        INNER JOIN `scholarship` C ON C.`code` = S.`code`
                        INNER JOIN `student` ST ON ST.`znumber` = S.`znumber`
                        LEFT JOIN `file` F ON f.`id` = A.`response`
                        WHERE S.`code` = :scholarship");
                    $applicationSELECT->bindValue(':scholarship', $_SESSION['scholarship'], \PDO::PARAM_STR);
                    $applicationSELECT->execute();
                }
            } else {
                if($_SESSION['scholarship'] == NULL){
                        // If znumber and no scholarship, list all applications from znumber
                    $applicationSELECT = $link->prepare("SELECT ST.`gpa`,ST.`year`,ST.`school`,ST.`major`,A.`response`,A.`summary`,A.`submitted`,S.`znumber`,S.`code`,S.`accepted`,S.`ranking`,S.`note`,B.`question`,B.`type`,C.`name`,C.`description`,C.`counter`,C.`limit`,F.`id`,F.`name` as `fname` 
                        FROM `answer` A
                        INNER JOIN `question` B ON B.`id` = A.`question_id`
                        INNER JOIN `student_scholarship` S on S.`id` = A.`stu_schID`
                        INNER JOIN `scholarship` C ON C.`code` = S.`code`
                        INNER JOIN `student` ST ON ST.`znumber` = S.`znumber`
                        LEFT JOIN `file` F ON f.`id` = A.`response`
                        WHERE S.`znumber` = :znumber");
                    $applicationSELECT->bindValue(':znumber', $_SESSION['znumber'], \PDO::PARAM_STR);
                    $applicationSELECT->execute();
                } else {
                        // if znumber and scholarship, list application for scholarship from znumber
                    $applicationSELECT = $link->prepare("SELECT ST.`gpa`,ST.`year`,ST.`school`,ST.`major`,A.`response`,A.`summary`,A.`submitted`,S.`znumber`,S.`code`,S.`accepted`,S.`ranking`,S.`note`,B.`question`,B.`type`,C.`name`,C.`description`,C.`counter`,C.`limit`,F.`id`,F.`name` as `fname` 
                        FROM `answer` A
                        INNER JOIN `question` B ON B.`id` = A.`question_id`
                        INNER JOIN `student_scholarship` S on S.`id` = A.`stu_schID`
                        INNER JOIN `scholarship` C ON C.`code` = S.`code`
                        INNER JOIN `student` ST ON ST.`znumber` = S.`znumber`
                        LEFT JOIN `file` F ON f.`id` = A.`response`
                        WHERE S.`znumber` = :znumber 
                        AND S.`code` = :scholarship");
                    $applicationSELECT->bindValue(':znumber', $_SESSION['znumber'], \PDO::PARAM_STR);
                    $applicationSELECT->bindValue(':scholarship', $_SESSION['scholarship'], \PDO::PARAM_STR);
                    $applicationSELECT->execute();
                }
            }
            $allapps = array();
            $application = $applicationSELECT->fetchAll();
            foreach($application as $num=>$row){
                $allapps[$row['znumber'].$row['code']][] = $row;
            }
        }
    } catch (\PDOException $ex){
        $error .= $ex->getMessage()."<br />";
    } catch (Exception $ex){
        $error .= $ex->getMessage()."<br />";
    }
}
?>
<?php //include "header.php" ?>
<?php
$isActive = true;
$closedText = "Scholarship Applications for the 2016-2017 School Year Have Closed";
?>
<!DOCTYPE HTML>
<html lang="en" class="no-js">
  <!--  
    Created: 06/2014, Dyllan To
    Last Modified: 04/2015, Dyllan To
  -->
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>FAU Scholarship Application</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

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

    <?php
      //$_SESSION['aid_year'] = "1415";  /* Session variable changable for the aid year */
      $_SESSION['bottom_sentence'] = "Copyright © 2015-2016 FAU Office of Student Financial Aid. All rights reserved.";
    ?>
  </head>
  <body>
    <noscript>
      This Form requires JavaScript to be properly submitted. Please enable javascript, then refresh the page.
      Javascript is only being used for basic form validation
    </noscript>
    <div class="container" id="main">
      <div class="page-header">
        <img src="img/CENTYPECL.jpg" class="center-block">
        <h1>Financial Aid <small>Scholarship Application for 2017-2018</small></h1>
      </div>
     <?php if(!$isActive): ?>
  		<h2><?= $closedText ?></h2>
  		<?php 
  		include "footer.php";
  		exit;
  		?>
  	<?php endif; ?>
  	<!-- End Header -->
<style>
    .col-md-10~.col-md-10 {
        padding-top: 20px;
    }
    .popover form label {
        font-size: 14px;
        line-height: 1.42857143;
    }
    .help-block{
        margin-top: 0px;
        margin-bottom: 0px;
    }
</style>
<h2 class="text-center">FAU Financial Aid Scholarship Application<?= $_SESSION['admin'] == 2 ? " - Administrator <span class='glyphicon glyphicon-tower' aria-hidden='true'></span>" : " - Viewer" ?></h2>

<?php if($_SESSION['admin'] == 0): ?>
<!-- New Viewer Splash -->

	<div class="well">
	    <h3 class="text-center">Log In</h3>
	    <form class="form-horizontal" role="form" action="viewer.php" method="post">
	        <div class="form-group">
	            <label for="znumber" class="hidden-xs col-sm-2 control-label">Password</label>
	            <div class="col-xs-12 col-sm-4 col-sm-push-6">
	                
	            </div>
	            <div class="col-xs-12 col-sm-6 col-sm-pull-4">
	                <input name="permission" id="permission" class="form-control" type="password">
	            </div>
	        </div>
	        <div class="form-group">
	            <div class="col-sm-offset-2 col-sm-10">
	                <button type="submit" class="btn btn-primary">Submit</button>
	            </div> 
	        </div> 
	    </form>
	</div>

<?php elseif ($_SESSION['admin'] >= 1): ?>
<!-- Application Rendering -->
	<?php if(isset($_GET['submit']) && $_GET['submit'] == '1'): ?>
	    <div class="panel-group" id="accordion">
	        <?php foreach($allapps as $num=>$question):
	        if(!empty($_GET['onlyUndecided']) && !is_null($question[0]['accepted'])){
	            continue;
	        }?>
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <h3 class="panel-title text-center">
	                    <span class="pull-left">
	                        <?= is_null($question[0]['accepted']) ? "Undecided" : ($question[0]['accepted'] === '0' ? "Rejected" : "<a href=\"#\" data-toggle=\"tooltip\" data-placement=\"auto\" title=\"".$question[0]['accepted']."\">Accepted</a>") ?>
	                    </span>
	                    <a data-toggle="collapse" data-parent="#accordion" href="<?= "#collapse_".$question[0]['code']."_".$num ?>">
	                        <small><?= $question[0]['code'] ?></small> <?= $question[0]['name'] ?> ~ <?= $question[0]['znumber'] ?>
	                    </a>
	                    <a tabindex="0" data-toggle="popover" data-trigger="focus" data-html='1' data-content="GPA: <?= $question[0]['gpa'] ?></br>Year: <?= $question[0]['year'] ?></br>School: <?= $question[0]['school'] ?></br>Major: <?= $question[0]['major'] ?>">
	                    	Student Details
	                    </a>
	                    <?php
	                    // If they are an admin, show the make/change decision stuff 
	                    if($_SESSION['admin'] == 2):
	                        ?>
		                    <a class="pull-right" href="#" tabindex="0" data-placement="auto" data-toggle="popover" data-trigger="click focus" data-html="1" data-content=
		                    '<form class="form-horizontal">
		                        <div class="form-group">
		                            <label for="note" class="col-sm-2">Note</label>
		                            <div class="col-sm-10">
		                                <input name="note" app_id="<?=$question[0]['znumber']?>:<?=$question[0]['code']?>" class="form-control" placeholder="Notes" maxlength="50"
		                                <?= !empty($question[0]['note']) ? "value=\"".$question[0]['note']."\"" : ""; ?>
		                                "/>
		                            </div>
		                        </div>
		                        <input name="app_id" value="<?=$question[0]['znumber']?>:<?=$question[0]['code']?>" type="hidden">
		                        <div class="form-group">
		                            <label for="award" class="col-sm-2">Award</label>
		                            <div class="col-sm-10">
		                                <div class="input-group">
		                                    <input name="award" app_id="<?=$question[0]['znumber']?>:<?=$question[0]['code']?>" class="form-control" placeholder="Award Amount"
		                                    <?= !empty($question[0]['accepted']) ? "value=\"".$question[0]['accepted']."\"" : ""; ?>
		                                    "/>
		                                    <span class="input-group-addon" data-toggle="tooltip" data-html="1" data-placement="auto" title="Undecided: Do Nothing. <br />Rejected: Submit 0. <br />Accepted: Submit Award Amount (No $ or Decimal) ">?</span>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label for="rank" class="col-sm-2">Rank</label>
		                            <div class="col-sm-10">
		                                <input name="rank" app_id="<?=$question[0]['znumber']?>:<?=$question[0]['code']?>" class="form-control" placeholder="Ranking"
		                                <?= isset($question[0]['ranking']) ? "value=\"".$question[0]['ranking']."\"" : ""; ?>
		                                "/>
		                            </div>
		                        </div>
		                    </form>
		                    <button call="decision" class="btn btn-primary center-block" type="button">Decide!</button>'>
		                    <?= is_null($question[0]['accepted']) ? "Make" : "Change"; ?>
		                    Decision</a>
	                    <?php
	                    endif;
	                    ?>
	                </h3>
	            </div> <!-- ./panel-heading -->
	            <div id="<?= "collapse_".$question[0]['code']."_".$num ?>" class="panel-collapse collapse">
	                <div class="panel-body">
	                    <?php foreach($question as $row): ?>
	                        <div class="col-md-10">
	                            <div class="row">
	                                <div class="col-md-1"><strong>Question</strong></div>
	                                <div class="col-md-11"><?= eval(' ?>'.$row['question'].'<?php '); ?></div>
	                            </div>
	                        <div class="row">
	                            <div class="col-md-1"><strong>Response</strong></div>
	                                <div class="col-md-11">
	                                    <?php 
	                                    if($row['type'] == 1){
	                                        echo "Student has attached <a href=\"download.php?id=".$row['response']."\">".$row['fname']."</a> for this response.";
	                                    } else {
	                                        echo $row['response']; 
	                                    } ?>
	                                </div>  
	                            </div>
	                        </div>
	                    <div class="col-md-2">
	                    </div>
	                    <?php endforeach; ?>
	                    <!-- <a href="data:text/plain;base64,">Download</a> -->
	                </div>
	            </div>
	        </div> <!-- ./panel-default -->

	        <?php endforeach; ?>
	    </div>
	<?php endif; ?>

	<?php if(empty($_GET['lock'])): ?>
	<!-- Application Retrieval Form -->
	<div class="well">
	    <h3 class="text-center">View Application</h3>
	    <form class="form-horizontal" role="form" action="viewer.php" method="get">
	        <div class="form-group">
	            <label for="znumber" class="hidden-xs col-sm-2 control-label">Scholarship</label>
	            <div class="col-xs-12 col-sm-4 col-sm-push-6">
	                (Submitted/Limit) A limit of 0 means Unlimited Applications Allowed. If greyed out, scholarship is inactive.

	            </div>
	            <div class="col-xs-12 col-sm-6 col-sm-pull-4">
	                <select name="scholarship" id="scholarship" class="form-control" data-rule-required="true">
	                    <option selected value="any">Any</option>
	                    <?php 
	                    try{
	                            // Select all the scholarships, their codes, names, and whether they are active or not
	                        foreach($link->query("SELECT `code`,`name`,`active`,`aid_year`,`counter`,`limit` FROM `scholarship` ORDER BY `name`") as $row){
	                            // if active and aid year is appropriate
	                            //if($row['aid_year'] == $_SESSION['aid_year']) {
	                            echo "<option ";
	                            // echo $row['active'] ? "" : "disabled ";
	                                // if the scholarship session variable was set by index and it matches one of the listings, select it
	                            echo $_SESSION['scholarship']==$row['code']?"selected":"";
	                                // print the listing into the dropdown
	                            echo " value=\"".$row['code']."\">".$row['name']." (".$row['counter']."/".$row['limit'].")(".$row['code'].")</option>\n";
	                            //}
	                        }
	                    } catch (\PDOException $ex){
	                        $error .= $ex->getMessage()."<br />";
	                    } catch (Exception $ex){
	                        $error .= $ex->getMessage()."<br />";
	                    }
	                    ?>
	                </select>
	            </div>
	        </div>
	        <div class="form-group">
	            <div class="col-xs-12 col-sm-6 col-sm-push-2">
	                <input type="checkbox" name="onlyUndecided" value="1" <?php echo isset($_GET['onlyUndecided'])? "checked" : ""; ?>> Only show Undecided Applications
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="znumber" class="hidden-xs col-sm-2 control-label">Z-Number</label>
	            <div class="col-xs-12 col-sm-4 col-sm-push-6">
	                Either Z-Number or Full Name required
	            </div>
	            <div class="col-xs-12 col-sm-6 col-sm-pull-4">
	                <input name="znumber" id="znumber" class="form-control" placeholder="Z-Number" <?php echo isset($_SESSION['znumber']) ? "value=\"".$_SESSION['znumber']."\"" : "" ?> data-rule-pattern="^Z\d{8}$" data-rule-minlength="9" data-rule-maxlength="9" data-msg-pattern="Z number should have an upper-case Z followed by 8 digits" data-msg-minlength="Z number should have a Z followed by exactly 8 digits" data-msg-maxlength="Your Z number should have a Z followed by exactly 8 digits">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="firstname" class="hidden-xs col-sm-2 control-label">First Name</label>
	            <div class="col-xs-12 col-sm-4 col-sm-push-6">
	            </div>
	            <div class="col-xs-12 col-sm-6 col-sm-pull-4">
	                <input name="firstname"  id="firstname" class="form-control name_req" placeholder="First Name" <?php echo isset($_GET['firstname']) ? "value=\"".$_GET['firstname']."\"" : "" ?> data-msg-require_from_group="Please enter either the student's Z-Number or their First &amp; Last name." data-rule-skip_or_fill_minimum='[2,".name_req"]' data-msg-skip_or_fill_minimum="Please enter the Student's First &amp; Last Name">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="lastname" class="hidden-xs col-sm-2 control-label">Last Name</label>
	            <div class="col-xs-12 col-sm-4 col-sm-push-6">
	            </div>
	            <div class="col-xs-12 col-sm-6 col-sm-pull-4">
	                <input name="lastname"  id="lastname" class="form-control name_req" placeholder="Last Name" <?php echo isset($_GET['lastname']) ? "value=\"".$_GET['lastname']."\"" : "" ?> data-rule-skip_or_fill_minimum='[2,".name_req"]' data-msg-skip_or_fill_minimum="Please enter the Student's First &amp; Last Name">
	            </div>
	        </div>
	        <input type="hidden" name="submit" value="1">
	        <div class="form-group">
	            <div class="col-sm-offset-2 col-sm-10">
	                <button type="submit" class="btn btn-primary">Submit</button>
	                <?php if($_SESSION['admin'] == 1): ?>
	                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#adminModal">Admin Login</button>
	                    <a href="viewer.php?logout=1" class="btn btn-danger">Log Out</a>
	                <?php endif; ?>
	                <?php if($_SESSION['admin'] == 2): ?>
	                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#appControlModal">Application Control Panel</button>
	                <?php endif; ?>
	            </div> 
	        </div> 
	    </form>
	</div>
	<?php endif; ?>

	<!-- Admin Login Modal -->
	<div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-labelledby="adminModal" aria-hidden="true">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title">Admin Login</h4>
	            </div>
	            <form class="form-horizontal novalidate" role="form" action="viewer.php?submit=2" method="post">
	                <div class="modal-body">
	                    <div class="form-group">
	                        <label for="username" class="hidden-xs col-sm-2 control-label">Username</label>
	                        <div class="col-xs-12 col-sm-6">
	                            <input name="username"  id="username" class="form-control" placeholder="Username">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="password" class="hidden-xs col-sm-2 control-label">Password</label>
	                        <div class="col-xs-12 col-sm-6">
	                            <input name="password" type="password"  id="password" class="form-control" placeholder="Password">
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="submit" class="btn btn-primary">Log In</button>
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	                </div>
	            </form>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Applicaion Control Panel -->
	<div class="modal fade" id="appControlModal" tabindex="-1" role="dialog" aria-labelledby="appControlModal" aria-hidden="true">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title">Application Control Panel</h4>
	            </div>
	            <div class="modal-body">
	                <div role="tabpanel">
	                    <!-- Nav tabs -->
	                    <ul class="nav nav-tabs" role="tablist">
	                    	<!-- TODO: Re-Add Buttons when functional -->
	                        <li role="presentation" class="active"><a href="#appControl_Limit" aria-controls="appControl_Limit" role="tab" data-toggle="tab">Application Limits</a></li>
	                        <li role="presentation" class="disabled"><a href="#add_scholarship" aria-controls="add_scholarship" role="tab">Add a Scholarship</a></li>
	                        <li role="presentation" class="disabled"><a href="#edit_scholarship" aria-controls="edit_scholarship" role="tab">Edit a Scholarship</a></li>
	                        <li role="presentation" class="disabled"><a href="#add_question" aria-controls="add_question" role="tab">Add a Question</a></li>
	                        <li role="presentation" class="disabled"><a href="#edit_question" aria-controls="edit_question" role="tab">Edit Questions</a></li>
	                    </ul>
	                    <?php
	                    	try {
	                        	$question_data = $link->query("SELECT `id`,`type`,`question` FROM `question`");
	                    	} catch (\PDOException $ex){
		                        $error .= $ex->getMessage()."<br />";
		                    } catch (Exception $ex){
		                        $error .= $ex->getMessage()."<br />";
		                    }
	                    ?>
	                    <!-- Tab panes -->
	                    <div class="tab-content">
	                        <!-- START: Limit Controller -->
	                        <div role="tabpanel" class="tab-pane fade in active" id="appControl_Limit">
	                            <form class="form-horizontal" role="form">
	                                <div class="form-group">
	                                    <div class="col-xs-8">
	                                        <b>Scholarship Code:Scholarship Name</b>
	                                    </div>
	                                    <div class="col-xs-2">
	                                        <b>Submitted Applications</b>
	                                    </div>
	                                    <div class="col-xs-2">
	                                        <b>Max Allowed Submissions <a href="#" data-toggle="tooltip" title="Set value to 0 to have No Maximum"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a></b>
	                                    </div>
	                                </div>
	                                <?php
	                                foreach($link->query("SELECT `code`,`name`,`active`,`aid_year`,`counter`,`limit` FROM `scholarship`") as $row): 
	                                ?>
	                                <div class="form-group">
	                                    <div class="col-xs-8">
	                                        <?= $row['code'].":".$row['name'] ?>
	                                    </div>
	                                    <div class="col-xs-2">
	                                        <?= $row['counter'] ?>
	                                    </div>
	                                    <div class="col-xs-2">
	                                        <input type="number" class="form-control" name="<?= $row['code'] ?>" value="<?= $row['limit'] ?>">
	                                    </div>
	                                </div>
	                                <?php
	                                endforeach;
	                                ?>
	                            </form>
	                            <button call="changeLimit" type="button" class="btn btn-primary pull-right" data-dismiss="modal">Save</button> 
	                        </div>
	                        <!-- END: Limit Controller -->
	                        <!-- START: Add Scholarship -->
	                        <div role="tabpanel" class="tab-pane fade" id="add_scholarship">
	                            <form class="form-horizontal" role="form">
	                                <div class="form-group">
	                                    <div class="col-xs-2">
	                                        <b>Code</b>
	                                    </div>
	                                    <div class="col-xs-10">
	                                        <b>Scholarship Name</b>
	                                    </div>
	                                </div>
	                                <div class="form-group">
	                                    <div class="col-xs-2">
	                                        <input type="text" class="form-control" name="sch_code">
	                                    </div>
	                                    <div class="col-xs-8">
	                                        <input type="text" class="form-control" name="sch_name">
	                                    </div>
	                                    <div class="col-xs-2">
	                                    	<div class="checkbox">
	                                          <label>
	                                            <input type="checkbox" value="true" name="active" checked>
	                                            Active
	                                          </label>
	                                        </div>
	                                    </div>
	                                </div>
	                                <div class="form-group">
	                                    <div class="col-xs-12">
	                                        <label>Description</label>
	                                        <input type="text" id="sch_description" class="form-control" name="sch_description">
	                                    </div>
	                                </div>
	                                <div class="panel-group" id="add_scholarship_questions" role="tablist" aria-multiselectable="true">
	                                    <div class="panel panel-default">
	                                        <div class="panel-heading" role="tab" id="add_scholarship_questions_heading">
	                                            <h4 class="panel-title">
	                                                <a data-toggle="collapse" data-parent="#add_scholarship_questions" href="#add_scholarship_questions_collapse" aria-expanded="true" aria-controls="add_scholarship_questions_collapse">
	                                                    Questions
	                                                </a>
	                                            </h4>
	                                        </div>
	                                        <div id="add_scholarship_questions_collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="add_scholarship_questions_heading">
	                                            <div class="panel-body">
	                                                Check off the Questions you want to assign to this scholarship. If a question is not available, add it in the Add Question tab.
	                                                <?php
	                                                    foreach($question_data as $row):
	                                                ?>
	                                                    <div class="checkbox">
	                                                      <label>
	                                                        <input type="checkbox" value="<?= $row['id'] ?>" name="questions">
	                                                        <?= $row['id'].". ".$row['question'] ?>
	                                                      </label>
	                                                    </div>
	                                                <?php endforeach; ?>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </form>
	                            <button call="addScholarship" type="button" class="btn btn-primary pull-right" data-dismiss="modal">Save</button> 
	                        </div>
	                        <!-- END: Add Scholarship -->
	                        <!-- START: Edit Scholarship -->
	                        <div role="tabpanel" class="tab-pane fade" id="edit_scholarship">
	                            <form class="form-horizontal" role="form">
	                            </form>
	                            <button call="editScholarship" type="button" class="btn btn-primary pull-right" data-dismiss="modal">Save</button> 
	                        </div>
	                        <!-- END: Edit Scholarship -->
	                        <!-- START: Add Question -->
	                        <div role="tabpanel" class="tab-pane fade" id="add_question">
	                            <form class="form-horizontal" role="form">
	                            </form>
	                            <button call="addQuestion" type="button" class="btn btn-primary pull-right" data-dismiss="modal">Save</button> 
	                        </div>
	                        <!-- END: Add Question -->
	                        <!-- START: Edit Question -->
	                        <div role="tabpanel" class="tab-pane fade" id="edit_question">
	                            <form class="form-horizontal" role="form">
	                            </form>
	                            <button call="editQuestion" type="button" class="btn btn-primary pull-right" data-dismiss="modal">Save</button> 
	                        </div>
	                        <!-- END: Edit Question -->
	                    </div><!-- /.tab-content -->
	                </div>
	            </div><!-- /.modal-body -->
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Controller Response Modal -->
	<div class="modal fade" id="controllerModal" tabindex="-1" role="dialog" aria-labelledby="controllerModal" aria-hidden="true">
	    <div class="modal-dialog modal-sm">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title">Response</h4>
	            </div>
	            <div class="modal-body">Refresh to view changes made.</div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-primary" data-dismiss="modal" onClick="document.location.reload(true)">Refresh</button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Error Modal -->
	<div class="modal fade" id="errorModal">
	    <div class="modal-dialog modal-sm">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title">Error!</h4>
	            </div>
	            <div class="modal-body">
	                <p><?= empty($error) ? "" : $error ?></p>
	                <p>If you see this error and aren't sure why you got it, send an email to dto1@fau.edu with the steps you took to encounter this error</p>
	            </div>
	            <div class="modal-footer">
	                <!--button type="button" class="btn btn-primary" data-dismiss="modal" onClick="document.location.reload(true)">Refresh</button-->
	                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<?php
	// session destroy if not admin because why not
	if($_SESSION['admin'] == 0){
	    session_destroy();
	}?>

<?php endif; ?>
<?php include "footer.php" ?>
<script type="text/javascript">

    // Refreshes the page every 31 minutes // 1860000 milliseconds = 31 minutes
    // Php kills sessions every 30 minutes of inactivity. Refreshing the page forces log out. 1 minute safety to ensure session erasure
    setTimeout(function(){ window.location.reload(); }, 1860000);

    // Replace z with Z on Z-Numbers 
    $("#znumber").keyup(function(event) {
        if(event.which == 90){
            $(this).val($(this).val().replace(/z/, "Z"));
        }
    });

    // Function to post things to the Controller
    // then throws a modal for the response
    function postToController(code, content){
        $.post( "controller.php", {"code": code, "content": content}, function(data){
            console.log(data);
            if(data['status'] == "error"){
                // if error
                $('#errorModal .modal-body').append(data['message']);
                $('#errorModal').modal('show');
            } else 
            if(data['status'] == "success"){
                // if success
                $('#controllerModal .modal-title').text("Success!");
                $('#controllerModal .modal-body').prepend(data['message'] + "<br />");
                $('#controllerModal').modal('show');
            } else {
                // if other
                $('#controllerModal .modal-title').text(data['status']);
                $('#controllerModal .modal-body').prepend(data['message'] + "<br />");
                $('#controllerModal').modal('show');
            }
        });
    }

    // Listens for Decision button
    $(document).on('click','button[call="decision"]', function(){
        var submitted = {};
        $.each($(this).prev('form').serializeArray(), function(i, field) {
            submitted[field.name] = field.value;
        });
        /*if(submitted['award'] === "") { // If no award, 
            $('#errorModal').modal('show');
            $('#errorModal .modal-body').append("You must put an award decision.");
            return;
        }*/
        $('[data-toggle="popover"]').popover('hide');
        postToController(1,submitted);
    });

    // Listens for Scholarship Limit change Save
    $(document).on('click','button[call="changeLimit"]', function(){
        var submitted = {};
        $.each($(this).prev('form').serializeArray(), function(i, field) {
            submitted[field.name] = field.value;
        });
        postToController(2,submitted);
    });

    // Listens for Add Scholarship Save
    $(document).on('click','button[call="addScholarship"]', function(){
        var submitted = {};
        submitted["questions"] = [];
        $.each($(this).prev('form').serializeArray(), function(i, field) {
            if(field.name == "questions"){
                submitted["questions"].push(field.value);
            } else 
           	if(field.name == "active"){
           		submitted["active"] = field.value == "true" ? '1' : '0';
            } else {
                submitted[field.name] = field.value;
            }
        });
        console.log(submitted);
        postToController(3,submitted);
    });

<?php
    // Shows Error Modal with Printout of Errors. Only if Admin. (php)
    if((!empty($error) && $_SESSION['admin'] == 2) || (!empty($error) && $error == "Invalid Username/Password.<br />")): ?>
        // Displays the Error Modal if relevant
        $('#errorModal').modal('show');
    <?php endif;?>

    // Puts focus on Username for Admin Modal
    $('#adminModal').on('shown.bs.modal', function () {
        $('#username').focus();
    });

        // Required for Functional Popovers and Tooltips 
    $(function () {
        $('body').popover({
            selector: '[data-toggle="popover"]'
        });

        $('body').tooltip({
            selector: 'a[rel="tooltip"], [data-toggle="tooltip"]'
        });
    });
    $('html').on('click', function(e) {
        if (typeof $(e.target).data('original-title') == 'undefined' && !$(e.target).parents().is('.popover.in')) {
            $('[data-original-title]').popover('hide');
        }
    });
        // Prevents blank anchors from doing weird things/resetting page position
    $("a[href='#']").click(function() {
        event.preventDefault();
    });   
    </script>
</body>
</html>