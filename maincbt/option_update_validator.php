<?php
   
    if(!isset($tokenizer)){
		echo "Token missing for <b>option_update_validator</b> file";
		exit();
	}
	
	$pp = x_getsingleupdate("option_update","status","id='1'");
	
	if($pp == 'Allow'){
		
		include("option_update.php");

	}
	
	if($pp == 'Disallow'){

		$msg="<img src='image/sor.png' style='width:250px;'/>";
		echo "<p style='color:green'>" .$msg . "</p>" ;
	
	}

?>