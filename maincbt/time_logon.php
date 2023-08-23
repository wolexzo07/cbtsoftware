<?php
if(x_count("exam_timer","id='1' LIMIT 1") > 0){
	
	$status = x_getsingleupdate("exam_timer","status","id='1'");
	
	if($status == 'on'){
		
		include("timer_seconds.php");
		$timet = time() + $seconds;		
		setcookie("$exam_token" ,"$exam_token" , $timet);
				
	} 
	
	if($status == 'off'){
	 
	}
	
	$status_switch = array("on","off");
	
	if(!in_array($status , $status_switch)){
		
		echo "invalid time status";
		
	}


}else{
	x_print("Timing system failed");
}
?>
