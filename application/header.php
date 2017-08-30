<?php
$closedText = "Scholarship Applications for the 2016-2017 School Year Have Closed. Applications for 2017-2018 open January 15th, 2017 at 11:59PM.";
$openTime = "2017-01-15 23:59:59"; // YYYY-MM-DD HH:MM:SS Format is important. Use same format for closeTime
$closeTime = false;
if(time() > strtotime($openTime) && (time() < $closeTime || $closeTime == false)){
	$isActive = true;
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