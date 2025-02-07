<?php
$pageToken = md5(uniqid());
if(x_count("cross_platform_mode","id='1'") > 0){
	
  $login = x_session("SESS_D_USER_EXAM"); 
  $user = x_session("SESS_D_MAT_NO_EXAM");
  $courses =  x_session("course_session");

 // Randomization of questions for users
 
 $order_option = x_getsingleupdate("multiple_choice","status","user ='$login' OR user='$user'");
 
 $order_desc_asc = x_getsingleupdate("multiple_choice","arrangement","user ='$login' OR user='$user'");
 
 $chty = $order_option; $arrt = $order_desc_asc;
	
	$get_Platform_mode = x_getsingleupdate("cross_platform_mode","status","id='1'");
	
	if($get_Platform_mode == "enable"){
		
	    include("pagination_part_one.php");
		
	}else{
		
		include("pagination_part_two.php");
		
	}
	
}else{
	$msg="<b>No status for cross platform examinations</b>";
	echo $msg;
}

