<?php
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
session_start();
header('Content-Type: application/json');

function exception_error_handler($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}
set_error_handler("exception_error_handler");


/*
Submit Codes
0 - Do Nothing
1 - Insert Decision
2 - Change Limit

*/
$return = array();
$date = date("Ymd"); // current date in yearmonthday format. For example, March 13, 2015 is 20150313
$log_path = "log/application_viewer_" . $date . ".txt"; // The logs name!
$log_date = date("Ymd His ").$_SESSION['user']."\t";
try{
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
    if(!empty($_SESSION['admin']) && $_SESSION['admin'] == 2 && !empty($_POST['code']) && !empty($_SESSION['user'])){
        $log = fopen($log_path,"at");
        if($log === false){
            // Throws an exception if it couldn't open or create the log file, and prevents anything from happening. 
            throw new Exception("Could not create/open log file; ABORTING ACTION");
        }
        
        switch($_POST['code']){
            case "1": // Insert Decision
                $decide = $_POST['content'];
                /*if(is_null($decide['award'])){ // If there's no award data, do nothing
                    fwrite($log, $log_date . "Decision\t".$decide['app_id']." Error Occurred: Award Empty\n");
                    throw new Exception("Award Empty");
                }*/
                try {
                    $link->beginTransaction();
                    $app_id = explode(":",$decide['app_id']); // $app_id is a uid for an application. It is znumber:sch_code
                    $decisionUPDATE = $link->prepare("UPDATE `student_scholarship` SET `accepted` = :accept, `ranking` = :rank, `note` = :note WHERE `znumber`=:znumber AND `code`= :sch_code LIMIT 1");
                    $decisionUPDATE->bindValue(':accept', is_null($decide['award'])?NULL:$decide['award'], \PDO::PARAM_STR);
                    $decisionUPDATE->bindValue(':rank', empty($decide['rank'])?NULL:$decide['rank'], \PDO::PARAM_STR);
                    $decisionUPDATE->bindValue(':note', $decide['note'], \PDO::PARAM_STR);
                    $decisionUPDATE->bindValue(':znumber', $app_id[0], \PDO::PARAM_STR);
                    $decisionUPDATE->bindValue(':sch_code', $app_id[1], \PDO::PARAM_STR);
                    $decisionUPDATE->execute();
                    if($decide['award'] === 0){
                    	$counterIncrease = $link->prepare("UPDATE `scholarship` SET `limit` = IF(`limit` = 0, 0, `limit` + 1) WHERE `code` = :code");
                    	$counterIncrease->bindValue(':code', $app_id[1], \PDO::PARAM_STR);
                    	$counterIncrease->execute();
                    }
                    $link->commit();
                    fwrite($log, $log_date . "Decision\t".$decide['app_id']." Award: ".$decide['award']." Rank: ".$decide['rank']." Note: ".$decide['note']."\n");
                    $return['status'] = "success";
                    $return['message'] = "Decision Submitted!";
                } catch (Exception $ex){
                    $link->rollBack();
                    fwrite($log, $log_date . "Error Occurred: ".$ex->getMessage()."\n");
                    $return['status'] = "error";
                    $return['message'] = $decide['rank']."||".$ex->getMessage();
                }
                break;
            case "2": // Change Limit Amount
                try {
                    $link->beginTransaction();
                    $limitArr = $_POST['content'];  // scholarship_code => limit_amount
                    $limitUPDATEq = "UPDATE `scholarship` JOIN ("; // Update the scholarship, Join it with a generated table
                    $joinedUnion = "";
                    $log_build = "";
                    foreach($limitArr as $sch_code => $limitAmount){ // Loops through array
                        if(is_numeric($limitAmount)){ // If the limit amount is a number
                            $log_build .= $sch_code . ":" . $limitAmount . "\t";
                            $joinedUnion .= " SELECT '$sch_code' AS `oldval`, '$limitAmount' AS `newval` UNION ALL"; // Create a table with columns oldval and newval, save respectively
                        }
                    }
                    $limitUPDATEq .= rtrim($joinedUnion,"UNION ALL")." ) q ON `scholarship`.`code` = `q`.`oldval` SET `limit` = `q`.`newval`"; // 
                    $limitUPDATE = $link->prepare($limitUPDATEq); 
                    $limitUPDATE->execute();
                    $link->commit();
                    fwrite($log, $log_date . "Set Limit:\t". $log_build."\n");
                    $return['status'] = "success";
                    $return['message'] = "Limit Updated!";
                } catch (Exception $ex){
                    $link->rollBack();
                    fwrite($log, $log_date . "Error Occurred: ".$ex->getMessage()."\n");
                    $return['status'] = "error";
                    $return['message'] = $ex->getMessage();
                }
                break;
            case "3": // Add Scholarship
            	try{
            		$link->beginTransaction();
            		$scholarship = $_POST["content"];
            		$scholarshipINSERT = $link->prepare("INSERT INTO `scholarship` (`code`,`name`,`description`,`active`) VALUES (:code, :name, :description, :active)");
            		$scholarshipINSERT->bindValue(':code', $scholarship['sch_code'], \PDO::PARAM_STR);
            		$scholarshipINSERT->bindValue(':name', $scholarship['sch_name'], \PDO::PARAM_STR);
            		$scholarshipINSERT->bindValue(':description', $scholarship['sch_description'], \PDO::PARAM_STR);
            		$scholarshipINSERT->bindValue(':active', $scholarship['active'], \PDO::PARAM_INT);
            		$scholarshipINSERT->execute();

            		if(!empty($scholarship['questions'])){
	            		$sch_questionINSERTquery = "INSERT INTO `scholarship_question` (`code`,`questionID`) VALUES ";
	            		foreach($scholarship['questions'] as $question){
	            			$sch_questionINSERTquery .= "(\"".$scholarship['sch_code']."\",".$question.")";
	            			if($question != end($scholarship['questions']))
	            				$sch_questionINSERTquery .= ",";
	            		}
	            		$link->exec($sch_questionINSERTquery);
            		}
	            	$link->commit();
					fwrite($log, $log_date . "Added Scholarship Code: ".$scholarship['sch_code']."\n");
					$return['status'] = "success";
					$return['message'] = "Scholarship Code: ".$scholarship['sch_code']." added";
            	} catch (Exception $ex){
            		$link->rollBack();
                    fwrite($log, $log_date . "Error Occurred: ".$ex->getMessage()."\n");
                    $return['status'] = "error";
                    $return['message'] = $ex->getMessage();
            	}
            	break;
            case "0":
            default:
                break;
        }
        fclose($log);
    } else {
        if (empty($_SESSION['admin']) || $_SESSION['admin'] != 2){
            $return['status'] = "error";
            $return['message'] = "Not an Admin";
        } else 
        if (empty($_POST['code'])){
            $return['status'] = "error";
            $return['message'] = "No code submitted";
        } else 
        if (empty($_SESSION['user'])){
            $return['status'] = "error";
            $return['message'] = "Not Logged In/No Username";
        }
    }
} catch (\PDOException $ex){
    $return['status'] = "error";
    $return['message'] = $ex->getMessage();
} catch (Exception $ex){
    $return['status'] = "error";
    $return['message'] = $ex->getMessage();
}
echo json_encode($return);
?>