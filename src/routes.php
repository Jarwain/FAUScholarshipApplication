<?php
// Routes

require 'middleware.php';
$app->group('/api', function(){
	//$database = $this->db;new PDODatabase();
	require 'routes/scholarship.php';
	require 'routes/application.php';
})->add($jsonCheck)->add($dbTransaction)->add($generalExceptions);