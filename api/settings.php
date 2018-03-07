<?php 
$settings = json_decode(file_get_contents("../.config/database"));

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = $settings->host;
$config['db']['user']   = $settings->user;
$config['db']['pass']   = $settings->pass;
$config['db']['dbname'] = $settings->dbname;