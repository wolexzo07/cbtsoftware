<?php
	if(!isset($tokenizer)){
			echo "Token missing for <b>stopit</b> file";
			exit();
		}
		
 if(x_count("exam_timer","id='1' LIMIT 1") > 0){
	
	$status = x_getsingleupdate("exam_timer","status","id='1'");
		
	if($status == 'on'){
	
		include("timer_seconds.php");
	
		if(!isset($_COOKIE["$exam_token"])){
			$msg="<b style='color:red'>Your time has expired</b>";
			echo $msg;
			exit();
		}
	
	}
	
	if($status == 'off'){
		
		
	}
	
	$status_switch = array("on","off");
	
	if(!in_array($status , $status_switch)){
		
		echo "invalid time status";
		
	}
	

}else{
	//No time was set
}

?>
