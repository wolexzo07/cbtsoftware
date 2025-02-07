<?php
	session_start();
	// CORS BYPASS
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: PUT, GET, POST");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

	include("xe-library/xe-library74.php");
	
	if(x_validateget("hasher") && x_validateget("cmd")){
		
		$hasher = xg("hasher"); $cmd = xg("cmd"); $ptoken = sha1(uniqid());
		
		// user controller
		
		include("userController.php");
		
		// admin Controller
		
		//include("adminController.php");
		
	}
?>