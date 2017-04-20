<?php
// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');

// Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');
session_start();
// If Session vars haven't been established, assign them
if(isset($_POST['submitted'])){
  $_SESSION['student']['fafsa'] = $_POST['fafsa'];
  $_SESSION['student']['need'] = $_POST['need'];
  $_SESSION['student']['gpa'] = $_POST['gpa'];
  $_SESSION['student']['year'] = $_POST['year'];
} else {
  header("location: index.php");
}
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
        $link = new \PDO( 'mysql:host=boc22finaid.fau.edu;dbname=scholarship_applications_test;charset=utf8mb4',
          'schapp',
          'schapp',
          array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_PERSISTENT => false
          )
        );
      } catch (\PDOException $ex){
         echo "<script>console.log(\"There was an Exception in PhP. ".$ex->getMessage()."\")</script>";
      } catch (Exception $ex){
        echo $ex;
         echo "<script>console.log(\"There was an Exception in PhP. ".trim($ex->getMessage())."\")</script>";
      }

      /*
        Select all scholarships, left join with all restrictions. Transform into a different format. Filter.
      */
      $wholething = $link->query("SELECT * FROM `scholarship` s 
      	LEFT JOIN `restriction` r ON s.`code` = r.`sch_code` 
      	WHERE s.`code` like 'TST%'");
      print_r($wholething);
      ?>
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Qualified Scholarships
              </a>
            </h4>
          </div>
          <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
              Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
            </div>
          </div>
        </div>
        <div class="panel panel-default">
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