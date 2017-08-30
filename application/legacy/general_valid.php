<?php

function CheckEscapeChar($value){
  //Desc: Check any invalid char in fieldValue
  //Input: value
  //Return: True if value is not found, False otherwise
  
  // Note that # is used as a delimiter, because using / causes issues
  return preg_match("#^[^,\\\/|~`!?><'\"&$%]+$#", $value);
}

/* Checks validity of input. This is the Second Validation Check*/
$invalid = false;

// zNumbers must be 8 digits
if(!isset($_SESSION['student']['znumber']) || mb_strlen($_SESSION['student']['znumber']) != 9 || CheckEscapeChar($_SESSION['student']['znumber']) == false || preg_match("/^Z\d{8}$/i", $_SESSION['student']['znumber']) == false){
  $invalid = true;
}

if(!isset($_SESSION['student']['firstname'])  || CheckEscapeChar($_SESSION['student']['firstname']) == false){
  $invalid = true;
}
if(!isset($_SESSION['student']['lastname'])  || CheckEscapeChar($_SESSION['student']['lastname']) == false){
  $invalid = true;
}
// Checks for valid FAU email
if(!isset ($_SESSION['student']['email']) || preg_match("/^.+@(my\.)?fau\.edu$/i", $_SESSION['student']['email']) == false  || CheckEscapeChar($_SESSION['student']['email']) == false){
  $invalid = true;
}

if($invalid){
  header("location: index.php?redirect=true");
  exit;
}

