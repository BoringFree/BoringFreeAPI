<?php

error_reporting(E_ALL);
ini_set('display_errors',true);

define ('APP',1);

//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: GET, POST, ACCEPT, OPTIONS");

session_start();

include_once (__DIR__ . '/config.php');
include_once (__DIR__ . '/Bored.class.php');

DB::connect();

$api = new BoredApi();
$api->init();

