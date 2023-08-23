<?php
 if(!isset($tokenizer)){
		echo "Token missing for <b>option_validator</b> file";
		exit();
	}
	
	$ps = x_getsingleupdate("allow_status","status","id='1'");
	
	if($ps == 'Allow'){
		echo " <b style='color:maroon'>Selected Option = " . $user_answer." ;</b>";
		echo "&nbsp;&nbsp;";
		echo " <b style='color:maroon'>"."correct"."</b>&nbsp; <img src='image/correct.png' style='height:20px;width:20px'/>";
	}
	
	if($ps == 'Disallow'){
		echo " <b style='color:maroon'>Selected Option = " . $user_answer." ;</b>";
		echo "&nbsp;&nbsp;";
	}
	
?>