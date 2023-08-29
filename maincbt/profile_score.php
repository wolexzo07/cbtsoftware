<?php
// modification started
	
	if(x_validatesession("SESS_D_USER_EXAM")){
		
		$user_p = x_clean(x_session("SESS_D_USER_EXAM"));
		
		if(x_dcount("subject","exams_scores","Score_approval = 'approved' AND script_owner='$user_p' LIMIT 1") > 0){
			?>
			<table cellpadding="10px" width="100%" cellspacing="0px" border="1px" style="font-size:11pt;">
			<tr style="background-color:lightgreen;color:purple"><th align="left">SUBJECTS / COURSES </th><th align="left">SCORES </th></tr>
			<?php
			foreach(x_distinct("subject AS categories","exams_scores","Score_approval = 'approved' AND script_owner='$user_p'","50","id desc") as $subject){
				
				$cat_p = xup($subject['categories'],"");
				
				$rut_numb = x_count("questions","approval_status='approved' AND categories='$cat_p'");

				include("subject_sc.php");

				if($scor_p ==  ""){
					echo "<tr><td>$cat_p</td><td><b>0&nbsp; out of &nbsp;$rut_numb</b></td></tr>";
				}
				else{
					echo "<tr style='background-color:white;color:purple'><td>$cat_p</td><td><b>$scor_p &nbsp;out of &nbsp;$rut_numb</b></td></tr>";
				}

			}
			echo "<tr style='background-color:lightgreen;color:purple'><td><b>AGGREGATE</b></td><td><b>$total_p</b></td></tr>";
			?>
			</table>
			<?php
		}else{
				echo "No subject found in the database";
			}
		
	}else{
		echo "No active session to display result!!!";
		exit();
	}
	
// modification ended

?>
