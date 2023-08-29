<?php
	include("auth.php");
	
	$owner = x_clean(x_session("SESS_D_USER_EXAM"));
	$namm = x_clean(x_session("SESS_D_NAME_EXAM"));
	
	if(x_count("result_button","status='disable'") > 0){
			include("no_res.php");
			exit();
		}
	
	// publishing status
	
	$p = x_getsingleupdate("instant_pub","instant_status","id='1'");
	
	if($p == "enabled"){
		
		include("exam_st.php");
		include("cross_status.php");
		
		x_update("exams_scores","script_owner='$owner' AND Score_approval='pending'","Score_approval='approved'","Script approval granted","Failed to update script"); // auto-marking of script initialized
			
		if(x_count("exams_scores","script_owner='$owner' AND Score_approval='pended' LIMIT 1") > 0){
			$msg = "<p style='padding:10px'><b>Result Pended!!</b></p>"  ;
			include("stat_p.php");
			exit();
		}

		if(x_count("exams_scores","script_owner='$owner' AND Score_approval='ceased' LIMIT 1") > 0){
				$msg = "<p style='padding:10px'><b>Result Ceased!!</b></p>"  ;
				include("stat_c.php");
				exit();
			}
			
		
		$qu_num = x_count("questions","approval_Status='approved'");// total questions

		$wr_count = x_count("exams_scores","script_owner='$owner' AND final_comment='wrong' AND Score_approval='approved'"); // total wrong answers

		$num = x_count("exams_scores","script_owner='$owner' AND final_comment='correct' AND Score_approval='approved'"); // total correct answers

		$all_count = x_count("exams_scores","script_owner='$owner' AND Score_approval='approved'"); // total answered both correct & wrong

		if($num > 0){
			foreach(x_select("0","exams_scores","script_owner='$owner' AND final_comment='correct' AND Score_approval='approved'","0","id") as $row){
				
			}
		}

		$percent = ($num/$qu_num)*100;
		$m_percent = round($percent ,2);

		if($all_count > 0){
			
				if($m_percent < 50){

					$msg = "Failed! Try Again";
					$status = "Not Admitted Yet";
					include('res_ext.php');

				}
				
				if($m_percent >= 50 && $m_percent < 90){
					$msg = "Passed! Congrat"  ;
					$status = "Admitted";
					include('res_ext.php');

				}
				
				if($m_percent > 90){
					$msg = "Superb! Congrat"  ;
					$status = "Admitted";
					include('res_ext.php');

				}
			
			}else{
			  
			  $msg = "<p style='padding:10px'>Please check back for your result</p>"  ;
			  include("stat.php");
			  
			}
		
	}
	
	if($p == "disabled"){
		
		$msg = "<p style='padding:10px'>Instant result publishing was disabled! Kindly reachout to the examiners!</p>";
	     include("stat.php");
		
	}
?>