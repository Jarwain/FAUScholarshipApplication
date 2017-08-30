<?php
// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');
 
// Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');
session_start();
$err = "";
$err2 = "";

include "general_valid.php";

/* Session variable to prevent users from bypassing a page, and to track the user */
if(!isset($_SESSION['location']) || $_SESSION['location'] != "verify"){
  header("location: index.php?".$_SESSION['location']);
  exit;
}  

// Now lets save it ALL to the database!
try{
	// Include Connection Settings
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

	$link->beginTransaction();
	// Set the uniqueApplication ID to -1
	$stu_schID = -1;

	// Insert Student to table
	// If Student exists, it doesn't matter! ()
	$studentINSERT = $link->prepare("INSERT IGNORE INTO `student` VALUES(:znumber,:firstname,:lastname,:email,:gpa,:year,:school,:major)");
	$studentINSERT->bindValue(':znumber', $_SESSION['student']['znumber'],\PDO::PARAM_STR);
	$studentINSERT->bindValue(':firstname', $_SESSION['student']['firstname'],\PDO::PARAM_STR);
	$studentINSERT->bindValue(':lastname', $_SESSION['student']['lastname'],\PDO::PARAM_STR);
	$studentINSERT->bindValue(':email', $_SESSION['student']['email'],\PDO::PARAM_STR);
	$studentINSERT->bindValue(':gpa', $_SESSION['student']['gpa'],\PDO::PARAM_STR);
	$studentINSERT->bindValue(':year', $_SESSION['student']['year'],\PDO::PARAM_STR);
	$studentINSERT->bindValue(':school', $_SESSION['student']['school'],\PDO::PARAM_STR);
	$studentINSERT->bindValue(':major', $_SESSION['student']['major'],\PDO::PARAM_STR);
	$studentINSERT->execute();

  	// Insert into student_scholarship db, recognize that student has submitted an app
	// Set the uniqueApplication ID if it hasn't been set
	// Update hte counter, too
	$stu_schINSERT = $link->prepare("INSERT INTO `student_scholarship`(`znumber`,`code`) VALUES(:znumber, :code)");
	$stu_schINSERT->bindValue(':znumber', $_SESSION['student']['znumber'], \PDO::PARAM_STR);
	$stu_schINSERT->bindValue(':code', $_SESSION['scholarship'], \PDO::PARAM_STR);
	$stu_schINSERT->execute();
	$stu_schID = $link->lastInsertID();

	// Update the counter
	$counterUPDATE = $link->prepare("UPDATE `scholarship` SET `counter` = `counter` + 1 WHERE `code` = :code");
	$counterUPDATE->bindValue(':code', $_SESSION['scholarship'], \PDO::PARAM_STR);
	$counterUPDATE->execute();
  
  foreach($_SESSION['scholarshipFields'] as $key => $val){
    if(mb_substr($key, 0, 4) === "sch_" && !empty($val)){
      // if the $val pair is an array, it means that it is a file that needs to be handled appropriately
      if(is_array($val)){
        // Insert the file into the DB from temp folder. Unique key is the file md5.
        // Does not upload file if it does not have a unique MD5 HASH
        $fileINSERT = $link->prepare("INSERT IGNORE INTO `file`(`name`,`data`,`size`,`md5`) VALUES(:name,:data,:size,:hash)");
        $fileINSERT->bindValue(':name', $val['name'], \PDO::PARAM_STR);
        $fileINSERT->bindValue(':data', file_get_contents($val['location']), \PDO::PARAM_STR);
        $fileINSERT->bindValue(':size', $val['size'],\PDO::PARAM_STR);
        $fileINSERT->bindValue(':hash', md5_file($val['location']),\PDO::PARAM_STR);
        $fileINSERT->execute();

        // Grab the file ID
        // If the student uploaded a non-unique MD5, it grabs the one already in the DB
        $fileidSELECT = $link->prepare("SELECT `id` FROM `file` WHERE `md5` = :hash");
        $fileidSELECT->bindValue(':hash', md5_file($val['location']),\PDO::PARAM_STR);
        $fileidSELECT->execute();
        $id = $fileidSELECT->fetchAll(PDO::FETCH_COLUMN, 0);
        // Set $val to the file ID 
        $val = $id[0];

        // Technically valid but doesn't account for non-unique MD5s
        //$val = $link->lastInsertID();

        // Insert the student-file association to the appropriate table
        $student_file = $link->prepare("INSERT IGNORE INTO `student_file`(`znumber`,`fileID`) VALUES(:znumber, :fileID)");
        $student_file->bindValue(':znumber', $_SESSION['student']['znumber'],\PDO::PARAM_STR); 
        $student_file->bindValue(':fileID', $val,\PDO::PARAM_STR); 
        $student_file->execute();
      }
      // Get the question number
      $question_id = mb_substr($key,4);
      // Get the keywordlist from the table, and generate a summary
      $keyword_listSELECT = $link->prepare("SELECT `word` FROM `keyword` A
                                            INNER JOIN `keyword_list` B ON B.`wordID`=A.`id`
                                            INNER JOIN `scholarship_question` C ON C.`keyword_listID`=B.`id`
                                            WHERE C.`questionID` = :question");
      $keyword_listSELECT->bindValue(':question', $question_id, \PDO::PARAM_STR);
      $keyword_listSELECT->execute();
      $summary = array();
      foreach($keyword_listSELECT->fetchAll() as $keyword){
        // Regex matches all sentences that contain a given keyword
        preg_match_all("/\b[^\.\?\!]*\b".$keyword[0]."\b[^\.\?\!]*[\.\?\!\n]/i", $val, $matches);
        $summary = array_unique(array_merge($matches[0],$summary));
      }

      // Insert answers
      $answerINSERT = $link->prepare("INSERT INTO `answer`(`stu_schID`,`question_id`,`response`,`summary`) VALUES(:stu_schID, :question, :response, :summary)");
      $answerINSERT->bindValue(':stu_schID', $stu_schID, \PDO::PARAM_STR);
      $answerINSERT->bindValue(':question', $question_id, \PDO::PARAM_STR);
      $answerINSERT->bindValue(':response', $val, \PDO::PARAM_STR);
      $answerINSERT->bindValue(':summary', implode($summary), \PDO::PARAM_STR);
      $answerINSERT->execute();
    }
  }
  $link->commit();
}
catch (\PDOException $ex){
  if ($ex->getCode() == '23000'){
    $err .= "You've already submitted an application for this scholarship.";
  } else {
    $err2 .= $ex->getMessage();
  }
  $link->rollBack();
} 
catch (Exception $ex){
  $err2 .= $ex->getMessage();
  $link->rollBack();
}


// Disable when debugging
session_destroy();
?>
<?php include "header.php" ?>
    <?php if ($err !== ""){ ?>
      <p class="bg-danger"><strong>ERROR</strong> <br><?= $err ?><br>If you believe this error is mistaken, please contact the financial aid department.</p>
    <?php }else{ ?>
      <h2>Submitted</h2>
        <p>Thank you. Your Scholarship application for <?= $_SESSION['scholarshipFields']['name'] ?> has been submitted. <br>Click the button below if you would like to submit another application.</p>
<?php }?>
        <p><a href="index.php" class="btn btn-primary">New Application</a></p>
<?php include "footer.php" ?>
    </body>
</html>