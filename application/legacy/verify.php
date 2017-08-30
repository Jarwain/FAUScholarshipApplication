<?php
// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');
 
// Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');
session_start();

$scholarshipFields = array();
foreach($_POST as $key => $val){
  if(mb_strpos($key, 'sch_') !== FALSE){
    $_SESSION['scholarshipFields'][$key] = $val;
  }
}
foreach($_FILES as $key=>$value){
  if( mb_strpos($key, 'sch_') !== FALSE && 
      $value['error'] == 0 && 
      $value['size'] > 0 && 
      $value['size'] < 2097152){
    
    $uploadDir = 'uploads/';
    if(move_uploaded_file($value['tmp_name'], $uploadDir.$value['name']) && mb_strpos($value['name'],'.exe') === FALSE){
      $_SESSION['scholarshipFields'][$key] = array('name'=>$value['name'], 'location'=>$uploadDir.$value['name'], 'size'=> $value['size']);
    } else {
      header("location: scholarship.php");
      exit;
    }
  }
}

/* Checks validity of input. Again. */
include "general_valid.php";

$validLocation = ["verify","scholarship"];
/* Session variable to prevent users from bypassing a page, and to track the user */
if(!isset($_SESSION['location']) || !in_array($_SESSION['location'],$validLocation)){
  header("location: index.php?".$_SESSION['location']);
  exit;
} else {
  $_SESSION['location'] = "verify";
}
?>
<?php include "header.php" ?>
      <h2>Verify</h2>
      <p>Please ensure all information on this page is correct. If any of the information on this page is incorrect, click the "Edit" button by the appropriate section header. </p>
      <form id="application" class="form-horizontal" role="form" action="submit.php" method="post">
        <h3 class="bg-info text-center">Part 1: Personal Information <a href="/index.php?redirect=true"><small><span class="glyphicon glyphicon-pencil"></span> Edit</small></a></h3>
        <div class="form-group">
          <label for="znumber" class="hidden-xs col-sm-2 control-label">Z-Number</label>
          <div class="col-xs-12 col-sm-7">
            <p class="form-control-static"><?php echo htmlentities($_SESSION['student']['znumber'], ENT_QUOTES, "UTF-8");?></p>
          </div>
        </div>
        <div class="form-group">
          <label for="firstname" class="hidden-xs col-sm-2 control-label">First Name</label>
          <div class="col-xs-12 col-sm-7">
            <p class="form-control-static"><?php echo htmlentities($_SESSION['student']['firstname'], ENT_QUOTES, "UTF-8");?></p>
          </div>
        </div>
        <div class="form-group">
          <label for="lastname" class="hidden-xs col-sm-2 control-label">Last Name</label>
          <div class="col-xs-12 col-sm-7">
            <p class="form-control-static"><?php echo htmlentities($_SESSION['student']['lastname'], ENT_QUOTES, "UTF-8");?></p>
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="hidden-xs col-sm-2 control-label">FAU e-Mail Address</label>
          <div class="col-xs-12 col-sm-7">
            <p class="form-control-static"><?php echo htmlentities($_SESSION['student']['email'], ENT_QUOTES, "UTF-8");?></p>
          </div>
        </div>
        <div class="form-group">
          <label for="gpa" class="hidden-xs col-sm-2 control-label">FAU GPA</label>
          <div class="col-xs-12 col-sm-7">
            <p class="form-control-static"><?php echo htmlentities($_SESSION['student']['gpa'], ENT_QUOTES, "UTF-8");?></p>
          </div>
        </div>
        <div class="form-group">
          <label for="year" class="hidden-xs col-sm-2 control-label">FAU Year</label>
          <div class="col-xs-12 col-sm-7">
            <p class="form-control-static"><?php echo htmlentities($_SESSION['student']['year'], ENT_QUOTES, "UTF-8");?></p>
          </div>
        </div>
        <div class="form-group">
          <label for="school" class="hidden-xs col-sm-2 control-label">College</label>
          <div class="col-xs-12 col-sm-7">
            <p class="form-control-static"><?php echo htmlentities($_SESSION['student']['school'], ENT_QUOTES, "UTF-8");?></p>
          </div>
        </div>
        <div class="form-group">
          <label for="major" class="hidden-xs col-sm-2 control-label">Major/Area of Study</label>
          <div class="col-xs-12 col-sm-7">
            <p class="form-control-static"><?php echo htmlentities($_SESSION['student']['major'], ENT_QUOTES, "UTF-8");?></p>
          </div>
        </div>
        <h3 class="bg-info text-center">Part 2: Your Scholarship <a href="scholarship-selection.php"><small><span class="glyphicon glyphicon-pencil"></span> Edit</small></a></h3>
        <div class="form-group">
          <label for="scholarship" class="hidden-xs col-sm-2 control-label">Scholarship</label>
          <div class="col-xs-12 col-sm-7">
            <p class="form-control-static"><?php echo $_SESSION['scholarshipFields']['name'] ?></p>
          </div>
        </div>
        <h3 class="bg-info text-center">Part 3: Scholarship Information <a href="scholarship.php"><small><span class="glyphicon glyphicon-pencil"></span> Edit</small></a></h3>
        <?php foreach($_SESSION['scholarshipFields'] as $key=>$value){
          echo "<div class=\"form-group\">";
          echo "  <label for=\"".$key."\" class=\"hidden-xs col-sm-2 control-label\">".htmlentities($key, ENT_QUOTES, "UTF-8")."</label>";
          echo "  <div class=\"col-xs-12 col-sm-7\">";
          echo "    <p class=\"form-control-static\">";
          echo isset($value['name'])?$value['name']:$value;
          echo "</p>  </div>";
          echo "</div>";
        }
        ?>
        <div class="col-sm-offset-1 col-sm-10">
        	<h3>Information Release Authorization</h3>
 			<p>
				In compliance with the Federal Family Educational Rights and Privacy Act of 1974, Florida Atlantic University (FAU) may not release personally identifiable information from education records without the consent of the student.
			</p>
 
			<p>
				With this scholarship application, the following information will be released to the Financial Aid Scholarship Committee members:
			</p>
			<ul>
				<li>Grade Point Average (GPA)</li>
				<li>FAU Student ID # (Z#)</li>
			</ul>
 			<!--p>
				This release authorization is limited to the Scholarship Committee only and can be revoked upon written request at any time.
			</p-->
        </div>
        <div class="form-group">
          <div class="col-sm-offset-1 col-sm-10 checkbox">
            <label>
              <input type="checkbox" name="auth"  id="auth" data-rule-required="true" value="true" data-msg=" ">
              I authorize the release of this application, any relevant supporting information, and the above listed information from my education records to the Financial Aid Scholarship Committee members. I understand that the release authorization is limited to the Scholarship Committee and can be revoked upon written request at any time.
            </label>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-1 col-sm-10">
            <p class="bg-warning">By clicking Submit, you agree that all information on this page is correct. <br>
            Inaccurate information <em>will</em> make you ineligible for consideration for your scholarship. <br>
            You will not be able to make any changes to your scholarship application after submission. <br>
            You must authorize release before you can click submit (check the checkbox)</p>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-1 col-sm-2">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div> 
        </div>
      </form>
<?php include "footer.php" ?>
  <script>

  </script>
    </body>
</html>