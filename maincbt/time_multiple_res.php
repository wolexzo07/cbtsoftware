<?php
include("validatingPage.php");

if(x_validatepost("hid_key")){
	
  $select = "";
  
  if(x_validatepost("selector")){
	
	foreach($_POST['selector'] as $yt){
		
		$select = $yt;
		
		}
	}
	
	$key_post = xp("course_key");
	
	if(empty($select)){
		echo "<p style='color:red;letter-spacing:2px;margin-top:2%;margin-bottom:2%;float:left;'>You can't re-take the selected exam</p>";
		}else{
	
	if(x_count("subject_pin","subject='$select' AND pin='$key_post' LIMIT 1") > 0){
		
		// Fetching subject timer
		
		$gettimer = x_getsingleupdate("subject_pin","time_allocated","subject='$select' AND pin='$key_post'");
		
		$time_in_seconds = $gettimer * 60; // Converting current subject timing to seconds;
		
		$use = $_SESSION['SESS_D_USER_EXAM'];
		
		$_SESSION['course_session'] = $select; 
		
		// Mode bypass started
		
		if(x_count("mode_bypass","id='1'") > 0){
			
			$getstatus = x_getsingleupdate("mode_bypass","status","id='1'");  // Getting the bypass mode status
			
		}
		
		if(isset($getstatus)){
			
			$flist = array("enable","disable");
			
			if(in_array($getstatus ,$flist)){
				
				if($getstatus == "disable"){
					
					if(x_count("attendance_multiple","username='$use' AND subject='$select' LIMIT 1") > 0){
						
						echo "<p style='color:red;letter-spacing:2px;margin-top:2%;margin-bottom:2%'>You can't re-login to take this course (<b>$select</b>) again</p>";
					
					}else{
						
						include("time_cross.php");
						
					}
					
				}else{
					include("time_cross.php");
				}
				
			}else{
				echo "<p>Bypass retriction mode inactive!</p>";
			}

		}
		
		// Mode bypass Ended
		
	}else{
		echo "<p style='color:red;letter-spacing:2px;margin-top:2%;margin-bottom:2%'>Please enter the correct subject pin</p>";
		
		}
	
	}
}
?>
