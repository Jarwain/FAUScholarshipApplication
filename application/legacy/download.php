<?php
// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');
session_start();
if(isset($_GET['id'])){
  $id = $_GET['id'];

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

    $fileSELECT = $link->prepare("SELECT `name`,`data`,`size` FROM `file` WHERE id = :id");
    $fileSELECT->bindValue(':id', $id, \PDO::PARAM_INT);
    $fileSELECT->execute();
    $file = $fileSELECT->fetchAll()[0];
  } catch (\PDOException $ex){
    echo "<script>console.log(\"There was an Exception in PhP. ".$ex->getMessage()."\")</script>";
  } catch (Exception $ex){
    echo "<script>console.log(\"There was an Exception in PhP. ".$ex->getMessage()."\")</script>";
  }
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename="'.$file['name'].'"'); //<<< Note the " " surrounding the file name
  header('Content-Transfer-Encoding: binary');
  header('Connection: Keep-Alive');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');
  header('Content-Length: ' . $file['size']);
  echo $file['data'];
} else {
  header("location: viewer.php");
}