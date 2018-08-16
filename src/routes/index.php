<?php
use Slim\Http\Request;
use Slim\Http\Response;

require "api.php";
require "admin.php";
$app->get('/[{params:.*}/]', 'ScholarshipApi\Controller\ApplicationController:index');
