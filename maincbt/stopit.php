<?php

	if(!isset($tokenizer)){
		echo "Token missing for <b>stopit</b> file";
		exit();
	}
	
	$p = x_getsingleupdate("cross_platform_mode","status","id='1'");
	
	if($p == "enable"){
		if(x_validatesession("EXAM_RESULT_STOPPED")){
			$msg="<b style='color:red'>You cannot continue this exam!!!</b>";
			echo $msg;
			exit;
		}
	}
?>
