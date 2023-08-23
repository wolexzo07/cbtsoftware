<?php
	if(!isset($tokenizer)){
			echo "Token missing for <b>timer_seconds</b> file";
			exit();
		}
	$p_seconds = x_getsingleupdate("exam_timer","timer","id='1'");
	$exam_token = x_getsingleupdate("exam_timer","token","id='1'");
	$seconds = $p_seconds / 1000;
?>
