<?php
	session_start();
	include_once("finishit.php");
	include_once("main.php");

	if(x_validatesession("SESS_D_MEMBER_ID_EXAM")){

		$tokenizer = sha1(uniqid());
		include("time_logout.php");
		
	}else{
		
		$msg="Login before access!!";
		$token = sha1(md5("GodIsGreatOnXeLoWGC2023?"));
		finish("login-page?msg=$msg&token_generated=$token","0");
		exit();
		
	}
	
	
	
?>
