<?php
$settings = json_decode(file_get_contents("../.config/database"));

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = $settings->host;
$config['db']['user']   = $settings->user;
$config['db']['pass']   = $settings->pass;
$config['db']['dbname'] = $settings->dbname;

$config['debug'] = true;

if($config['debug']){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}