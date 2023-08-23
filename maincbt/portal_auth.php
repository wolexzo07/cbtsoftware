<?php
	if(!isset($tokenizer)){
			echo "Token missing for <b>portal_auth</b> file";
			exit();
	}
	
	$p = x_getsingleupdate("portal","portal_status","id='1'");
	
	if($p == "closed"){
		$msg="<b>Examination Portal is Closed</b>";
		echo $msg;
		exit();
	}
?>