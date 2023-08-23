<?php
	
	if(x_count("exam_timer","id='1' LIMIT 1") > 0){}else{
		finish("logout","Timing System Failed");
	}
	
	$status = x_getsingleupdate("exam_timer","status","id='1'");
	
	if($status == "on"){
		
		include("timer_seconds.php");
		
		if(!isset($_COOKIE["$exam_token"])){
			finish("logout","No cookie is active");
			exit();
		}
	}
	
	if($status == 'off'){

	}
?>
