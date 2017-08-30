<?php
// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');

// Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');
session_start();

if(isset($_POST['submitted'])){
  $_SESSION['scholarship'] = $_POST['scholarship']; // Assign the scholarschip code to the session
}


$validLocation = ["verify","scholarship","selection"];
/* Session variable to prevent users from bypassing a page, and to track the user */
if(!isset($_SESSION['location']) || !in_array($_SESSION['location'],$validLocation)){
  header("location: index.php?".$_SESSION['location']);
  exit;
} else {
  $_SESSION['location'] = "scholarship";
}

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
/*
  New Question Types:
  0 - Essay
  1 - File Upload
*/


  // Join question, scholarship, and scholarship_question, and return the sch code, sch name, sch descript, question content, and questionID
  $questionQuery = $link->prepare("SELECT A.`code`, A.`name`, A.`description`, C.`id`, C.`type`, C.`question`, C.`filetype`, C.`maxFileSize`, C.`maxWordCount`, C.`minWordCount` 
  	FROM `scholarship` A 
    LEFT JOIN `scholarship_question` B ON B.`code`= A.`code`
    LEFT JOIN `question` C ON C.`id`= B.`questionID`
    WHERE A.`code` = :code");
  $questionQuery->bindValue(':code', $_SESSION['scholarship'], \PDO::PARAM_STR);
  $questionQuery->execute();
  $sch_data = $questionQuery->fetchAll();
} catch (\PDOException $ex){
  // echo "<script>console.log(\"There was an Exception in PhP. ".$ex->getMessage()."\")</script>";
} catch (Exception $ex){
  // echo "<script>console.log(\"There was an Exception in PhP. ".$ex->getMessage()."\")</script>";
}
//echo $sch_data;
//if(is_null($sch_data[0])) header("location: scholarship-selection.php?what");

$_SESSION['scholarshipFields']['name'] = $sch_data[0]["name"]; // Assigns the scholarship name to the one from the database
?>
<?php include "header.php" ?>
<h2><?php echo $_SESSION['scholarshipFields']['name']; ?></h2>
<p>If this is the Incorrect Scholarship, click the back button. Otherwise, fill out the required fields.</p>
<h3 class="bg-info text-center">Part 3: Scholarship Information</h3>
<form role="form" action="verify.php" method="post" enctype="multipart/form-data">
    <?php 
    /*
    Current Implementation

    echo "<p>".$sch_data[0]['description']."</p>"; // prints the description of scholarship using data from first row
    ob_start();
    foreach($sch_data as $row){ // for every question as row
      $question_id = "sch_".$row['id']; // get question ID
      echo "<div class=\"form-group\">";
      echo eval(' ?>'.$row['question'].'<?php '); // evaluate and print question
      echo eval(' ?>'.$row['input'].'<?php '); // evaluate and print the input code
      echo "</div>";
    }
    $questionHTML = ob_get_contents();
    ob_end_clean();
    echo $questionHTML;*/
    // New Implementation
    ?>
    <p><?= $sch_data[0]['description'] // prints the description of scholarship using data from first row ?> </br>
    <b>Warning: If you do not meet the criteria for this scholarship, your application will be immediately disqualified.</b>
    </p>
    <?php
    if(!is_null($sch_data[0]['id'])){
	    ob_start();
	    $first = reset($sch_data);
	    foreach($sch_data as $row){ // for every question as row
	        $question_id = "sch_".$row['id'];
	        $maxFileSize = $row['maxFileSize'] / 1048576; // in MB
	        echo "<hr/>";
	        echo "<div class=\"form-group\">"; 
	        switch($row['type']){
	            case 0: // Essay Question 
	            echo "<p>".$row['question']."</p>";
	            if (!empty($row['maxWordCount']) || !empty($row['minWordCount'])){
	                if($row['maxWordCount'] > 0 && $row['minWordCount'] > 0)
	                    echo "<p>The essay must be between ".$row['minWordCount']." and ".$row['maxWordCount']." words</p>";
	                elseif ($row['maxWordCount'] > 0 && $row['minWordCount'] == 0)
	                    echo "<p>The essay must not exceed ".$row['maxWordCount']." words</p>";
	                elseif ($row['maxWordCount'] == 0 && $row['minWordCount'] > 0)
	                    echo "<p>The essay must be at least ".$row['minWordCount']." words</p>";

	            } ?>
	            <textarea name="<?= $question_id ?>" id="<?= $question_id ?>" class="form-control" rows="10" data-rule-required="true" <?php if(!empty($row['maxWordCount'])) echo "data-rule-maxWordCount=\"".$row['maxWordCount']."\""; if(!empty($row['minWordCount'])) echo "data-rule-minWordCount=\"".$row['minWordCount']."\""; ?> ><?php echo isset($_SESSION['scholarshipFields'][$question_id])?$_SESSION['scholarshipFields'][$question_id]:"";?></textarea>
	            <a href="#" data-html="true" data-toggle="tooltip" data-placement="right" title="Minimum[Word Count]Maximum<br />If Maximum is 0, there is no Maximum Word Count.">Word Count: <?= $row['minWordCount'] ?>[0]<?= $row['maxWordCount'] ?> <span class="glyphicon glyphicon-question-sign"></span></a>
	            <?php break;?>
	            <?php case 1: // File Upload 
	            echo "<p>".$row['question']."</p>"; ?>
	            <!--input type="hidden" name="MAX_FILE_SIZE" value="<?= $row['maxFileSize']?>"-->  <input name="<?= $question_id ?>" id="<?= $question_id ?>" type="file" data-rule-required="true" data-rule-extension="<?= $row['filetype']?>" data-rule-maxFileSize="<?= $row['maxFileSize'] ?>" data-msg-extension="Incorrect File Format" data-msg-maxFileSize="Your Transcript must be smaller than <?= $maxFileSize ?>MB">
	            <?php break;?>
	            <?php default: 
	            echo "Error with ".$question_id;
	        }
	        echo "</div>";
	    }
    }
    ?>
    <div class="form-group">
      <a href="scholarship-selection.php" class="btn btn-warning">Back</a>
      <button type="submit" class="btn btn-primary">Continue</button>
  </div>
</form>
  <?php include "footer.php"; ?>
  <script type="text/javascript">
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    // Word Count Code! Displays the wordcount
    $("[data-rule-maxWordCount]").on("blur keyup",function(){
        var wordMax = ~~$(this).attr("data-rule-maxWordCount");
        var wordMin = ~~$(this).attr("data-rule-minWordCount");
        var wordCount = getWordCount($(this).val());
        var wordText = "";
        if((wordCount > wordMax && wordMax > 0) || (wordCount < wordMin && wordMin > 0)){
            $(this).nextAll("a").first().attr("class","text-danger");
        } else {
            $(this).nextAll("a").first().attr("class","text-success");
        }
        if(wordMin >= 0) wordText += wordMin;
        wordText += "["+wordCount+"]";
        if(wordMax >= 0) wordText += wordMax;
        $(this).nextAll("a").first().html("Word Count: " + wordText + ' <span class="glyphicon glyphicon-question-sign"></span>');  
    });
    /*$("[data-rule-maxWordCount]").on("blur keyup",function(){
      var wordMax = ~~$(this).attr("data-rule-maxWordCount");
      var wordMin = ~~$(this).attr("data-rule-minWordCount");
      var wordCount = getWordCount($(this).val());
      $(this).next("p").text("Word Count: "+wordCount);
      if(wordCount <= wordMax && wordCount >= wordMin && wordCount != 0) $(this).nextAll("p").attr("class","text-success");
      if(wordCount > wordMax || wordCount < wordMin || wordCount == 0) $(this).nextAll("p").attr("class","text-danger");
    });*/
    </script>
</body>
</html>