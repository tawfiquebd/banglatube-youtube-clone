<?php
ob_start();	// Turns on output buffering
session_start();

date_default_timezone_set("Asia/Dhaka");

// Database connection

try{
	$con = new PDO("mysql:host=localhost; dbname=VideoTube", "root", "");
	$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
}
catch(Exception $e){
	echo "Connection Failed: ".$e->getMessage();
}

?>