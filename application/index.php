<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);?>

<?php
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
session_start();

?>
<?php include "header.php" ?>
      <h2>Scholarship Information</h2>
      <p>All fields are required. Application only submits once you press "Submit Application" at the end. The Application does not save. </p>
      <h3 class="bg-info text-center">Part 1: Personal Information</h3>
      <form class="form-horizontal" role="form" action="scholarship-selection.php" method="post">
        <input type="hidden" name="submitted" value="true">
        <div class="form-group">
          <label for="znumber" class="hidden-xs col-sm-2 control-label">Z-Number</label>
          <div class="col-xs-12 col-sm-3 col-sm-push-7">
            <!-- Place Information About the field here -->
            Example: Z87612345<br>
            You can obtain your Z-number by logging into your <a href="https://myfau.fau.edu">MyFAU</a> account
          </div>
          <div class="col-xs-12 col-sm-7 col-sm-pull-3">
          <?php //if $redirected to this page, load previous information. Consistent for all fields?>
            <input <?php echo !empty($_SESSION['student']['znumber'])?"value=\"".$_SESSION['student']['znumber']."\"":""?> name="znumber"  id="znumber" class="form-control" placeholder="Z-Number" required data-rule-pattern="^Z\d{8}$" data-rule-minlength="9" data-rule-maxlength="9" data-msg-pattern="Your Z number should have an upper-case Z followed by 8 digits" data-msg-minlength="Your Z number should have a Z followed by exactly 8 digits" data-msg-maxlength="Your Z number should have a Z followed by exactly 8 digits">
          </div>
        </div>
        <div class="form-group">
          <label for="firstname" class="hidden-xs col-sm-2 control-label">First Name</label>
          <div class="col-xs-12 col-sm-3 col-sm-push-7">
            If your First or Last name uses an invalid character, put a space instead. 
          </div>
          <div class="col-xs-12 col-sm-7 col-sm-pull-3">
            <input <?php echo !empty($_SESSION['student']['firstname'])?"value=\"".$_SESSION['student']['firstname']."\"":""?> type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name" required data-rule-invalidChar="true">
          </div>
        </div>
        <div class="form-group">
          <label for="lastname" class="hidden-xs col-sm-2 control-label">Last Name</label>
          <div class="col-xs-12 col-sm-3 col-sm-push-7">
            <!-- Place Information About the field here -->
          </div>
          <div class="col-xs-12 col-sm-7 col-sm-pull-3">
            <input <?php echo !empty($_SESSION['student']['lastname'])?"value=\"".$_SESSION['student']['lastname']."\"":""?> type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name" required data-rule-invalidChar="true">
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="hidden-xs col-sm-2 control-label">FAU e-Mail Address</label>
          <div class="col-xs-12 col-sm-3 col-sm-push-7">
            <!-- Place Information About the field here -->
            Example: jsmith24@fau.edu
          </div>
          <div class="col-xs-12 col-sm-7 col-sm-pull-3">
            <input <?php echo !empty($_SESSION['student']['email'])?"value=\"".$_SESSION['student']['email']."\"":""?> name="email" id="email" class="form-control" placeholder="FAU e-Mail" required data-rule-invalidChar="true" data-rule-email="true" data-rule-pattern="^.+@fau\.edu$" data-msg-pattern="Invalid FAU e-Mail Address" data-msg-email="Invalid FAU e-Mail Address">
          </div>
        </div>

        <div class="form-group">
          <label for="gpa" class="hidden-xs col-sm-2 control-label">GPA</label>
          <div class="col-xs-12 col-sm-3 col-sm-push-7">
            <!-- Place Information About the field here -->
            From 0-4, Rounded to the first decimal. Ex: 3.5
          </div>
          <div class="col-xs-12 col-sm-7 col-sm-pull-3">
            <input <?php echo !empty($_SESSION['student']['gpa'])?"value=\"".$_SESSION['student']['gpa']."\"":""?> name="gpa" id="gpa" class="form-control" placeholder="GPA" required data-rule-pattern="^([0-3]\.\d)|(4\.0)$" data-msg-pattern="Invalid GPA">
          </div>
        </div>
        <div class="form-group">
          <label for="year" class="hidden-xs col-sm-2 control-label">Class Standing</label>
          <div class="col-xs-12 col-sm-3 col-sm-push-7">
            <!-- Place Information About the field here -->
            
          </div>
          <div class="col-xs-12 col-sm-7 col-sm-pull-3">
          	<select name="year" id="year" class="form-control" required>
			  <option value="Freshman">Freshman</option>
			  <option value="Sophomore">Sophomore</option>
			  <option value="Junior">Junior</option>
			  <option value="Senior">Senior</option>
			  <option value="Graduate">Graduate</option>
			</select>
          </div>
        </div>
        <div class="form-group">
          <label for="school" class="hidden-xs col-sm-2 control-label">College</label>
          <div class="col-xs-12 col-sm-3 col-sm-push-7">
            <!-- Place Information About the field here -->
            Example: jsmith24@fau.edu
          </div>
          <div class="col-xs-12 col-sm-7 col-sm-pull-3">
            <select name="school" id="school" class="form-control" required>
			  <option value="Dorothy F. Schmidt College of Arts and Letters">Dorothy F. Schmidt College of Arts and Letters</option>
			  <option value="College of Business">College of Business</option>
			  <option value="College for Design and Social Inquiry">College for Design and Social Inquiry</option>
			  <option value="College of Education">College of Education</option>
			  <option value="College of Engineering and Computer Science">College of Engineering and Computer Science</option>
			  <option value="The Graduate College">The Graduate College</option>
			  <option value="Harriet L. Wilkes Honors College">Harriet L. Wilkes Honors College</option>
			  <option value="Charles E. Schmidt College of Medicine">Charles E. Schmidt College of Medicine</option>
			  <option value="Christine E. Lynn College of Nursing">Christine E. Lynn College of Nursing</option>
			  <option value="Charles E. Schmidt College of Science">Charles E. Schmidt College of Science</option>
			</select>
          </div>
        </div>
        <div class="form-group">
          <label for="major" class="hidden-xs col-sm-2 control-label">Major/Area of Study</label>
          <div class="col-xs-12 col-sm-3 col-sm-push-7">
            <!-- Place Information About the field here -->
            Example: Accounting, Computer Science, Biology, History
          </div>
          <div class="col-xs-12 col-sm-7 col-sm-pull-3">
            <input <?php echo !empty($_SESSION['student']['major'])?"value=\"".$_SESSION['student']['major']."\"":""?> name="major" id="major" class="form-control" placeholder="Area of Study" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Continue</button>
          </div> 
        </div>
      </form>
<?php include "footer.php" ?>