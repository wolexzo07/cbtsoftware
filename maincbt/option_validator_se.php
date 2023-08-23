<?php
	if(!isset($tokenizer)){
		echo "Token missing for <b>option_validator_se</b> file";
		exit();
	}
	
	$po = x_getsingleupdate("allow_status","status","id='1'");
	
	if($po == "Allow"){
		echo " <b style='color:maroon'>Selected Option = " . $user_answer." ;</b>";
		echo "&nbsp;&nbsp;";
		echo " <b style='color:maroon'>"."wrong"."</b>&nbsp;<img src='image/wrong.png' style='height:20px;width:20px'/>";
	}
	
	if($po == "Disallow"){
		echo " <b style='color:maroon'>Selected Option = " . $user_answer." ;</b>";
		echo "&nbsp;&nbsp;";
	}

?>