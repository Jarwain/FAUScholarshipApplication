<?php
// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');
 
// Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');
session_start();

// If Session vars haven't been established, assign them
if(isset($_POST['submitted'])){
  $_SESSION['student']['znumber'] = $_POST['znumber'];
  $_SESSION['student']['firstname'] = $_POST['firstname'];
  $_SESSION['student']['lastname'] = $_POST['lastname'];
  $_SESSION['student']['email'] = $_POST['email'];
  $_SESSION['student']['gpa'] = $_POST['gpa'];
  $_SESSION['student']['year'] = $_POST['year'];
  $_SESSION['student']['school'] = $_POST['school'];
  $_SESSION['student']['major'] = $_POST['major'];
}

include "general_valid.php"; // Checks for valid session vars. If they're invalid, return the user to the first page

$validLocation = ["index","verify","scholarship","selection"];
/* Session variable to prevent users from bypassing a page, and to track the user */
if(!isset($_SESSION['location']) || !in_array($_SESSION['location'],$validLocation)){
  header("location: index.php?".$_SESSION['location']);
  exit;
} else {
  $_SESSION['location'] = "selection";
}
?>
<?php include "header.php"; ?>
      <h2>Select Scholarship</h2>
      <p>Select the Scholarship you are interested in applying for. <br>
      If a scholarship you are interested in is not on this list, it is not available for this term. <br>
      If a scholarship is greyed out, it has reached the maximum number of applicants. </p>
      <h3 class="bg-info text-center">Part 2: Select a Scholarship</h3>
      <?php
      try{
        // Include connection Settings
        include "settings.php";   
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
        // echo "<script>console.log(\"There was an Exception in PhP. ".$ex->getMessage()."\")</script>";
      } catch (Exception $ex){
        echo $ex;
        // echo "<script>console.log(\"There was an Exception in PhP. ".$ex->getMessage()."\")</script>";
      }
      ?>
      <form class="form-horizontal" role="form" action="scholarship.php" method="post">
        <input type="hidden" name="submitted" value="true">
        <div class="form-group">
          <label for="scholarship" class="hidden-xs col-sm-2 control-label">Scholarship</label>
          <div class="col-xs-12 col-sm-3 col-sm-push-7">
            <!-- Place Information About the field here -->
          </div>
          <div class="col-xs-12 col-sm-7 col-sm-pull-3">
            <select name="scholarship" id="scholarship" class="form-control" data-rule-required="true">
              <option disabled selected>Select a Scholarship</option>
              <option disabled>--------------------</option>
              <?php 
              // Select all the scholarships, their codes, names, and whether they are active or not
              foreach($link->query("SELECT `code`,`name`,`active`,`aid_year`,`counter`,`limit` FROM `scholarship`") as $row){
                // if active and aid year is appropriate
                // && $row['aid_year'] == $_SESSION['aid_year']
                if($row['active']) {
                  echo "<option ";
                  // if the limit is hit, disable the option, then continue printing the option
                  if (!(($row['limit'] > 0 && $row['counter'] < $row['limit']) || $row['limit'] <= 0)) echo "disabled ";
                  // if the scholarship session variable was set by index and it matches one of the listings, select it
                  echo $_SESSION['scholarship']==$row['code']?"selected":"";
                  // print the listing into the dropdown
                  echo " value=\"".$row['code']."\">".$row['name'];
                  if (!(($row['limit'] > 0 && $row['counter'] < $row['limit']) || $row['limit'] <= 0)) echo " (Maximum Applications Reached)";
                  echo "</option>\n";
                }
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-2">
            <a href="index.php?redirect=true" class="btn btn-warning">Back</a>
            <button type="submit" class="btn btn-primary">Continue</button>
          </div> 
        </div>
      </form>
<?php include "footer.php"; ?>
      <script>
        $('form').validate();
      </script>
    </body>
</html>