<?php

	$owner = x_clean(x_session("SESS_D_USER_EXAM"));
	
	// getting answer for questions
	
	$answer_quest = x_getsingleupdate("questions","answer","id='$id'");
	
	// getting user selected answer 
	
	$user_answer = x_getsingleupdate("exams_scores","answer","script_owner='$owner' AND attempted_num='$id'");
	
	if(x_count("exams_scores","script_owner='$owner' AND attempted_num='$id'") > 0){
		
		// validating answers (correct | wrong)
	
		if(strtolower($answer_quest) == strtolower($user_answer)){
			
			include("option_validator.php");
			
		}else{
			
			include("option_validator_se.php");
			
		}
		
	}else{
		
	}
?>
