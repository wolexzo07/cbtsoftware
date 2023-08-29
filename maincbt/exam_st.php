<?php
if(x_count("cross_platform_mode","id='1'") > 0){
	
	$p = x_getsingleupdate("cross_platform_mode","status","id='1'");
	if($p == "enable"){
		$_SESSION['EXAM_RESULT_STOPPED'] = 'ok';
	}
}

?>

