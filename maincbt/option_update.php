<?php

 if(!isset($tokenizer)){
		echo "Token missing for <b>option_update</b> file";
		exit();
	}

    $owner = x_clean(x_session("SESS_D_USER_EXAM"));
	
	
	x_update("exams_scores","script_owner='$owner' AND attempted_num='$id'","answer='$opt'","answer was initialized","Failed to set answer");
	
	
	// getting answer for questions
	
	$answer_quest = x_getsingleupdate("questions","answer","id='$id'");
	
	// getting user selected answer 
	
	$user_answer = x_getsingleupdate("exams_scores","answer","script_owner='$owner' AND attempted_num='$id'");
	
	// validating answers (correct | wrong)
	
	if(strtolower($answer_quest) == strtolower($user_answer)){
		
		$score_point = 1; $remarks = "correct";
		
		x_update("exams_scores","script_owner='$owner' AND attempted_num='$id'","final_comment='$remarks' , score_point='$score_point'","option updated successfully","Failed to update option");
		
		include("option_validator.php");
		
	}else{
		
		$score_point = 0; $remarks = "wrong";
		
		x_update("exams_scores","script_owner='$owner' AND attempted_num='$id'","final_comment='$remarks' , score_point='$score_point'","option updated successfully","Failed to update option");
		
		include("option_validator_se.php");
		
	}


/****
$owner = $_SESSION['SESS_D_USER_EXAM'];
$updat = "UPDATE exams_scores SET answer='$opt' WHERE script_owner='$owner' AND attempted_num='$id' LIMIT 1";
$updateQueryer = mysqli_query($con,$updat);
if(!$updateQueryer){
$msg="Failed to Update user selected option";
echo $msg;
}
else{
$sqlCo = "SELECT answer FROM questions WHERE id='$id' LIMIT 1";
$quee = mysqli_query($con,$sqlCo);
$roww = mysqli_fetch_array($quee);
$sqlCommand = "SELECT answer FROM exams_scores WHERE script_owner='$owner' AND attempted_num='$id' LIMIT 1";
$que = mysqli_query($con,$sqlCommand );
$num = mysqli_num_rows($que);
$row = mysqli_fetch_array($que);

if(strtolower($roww["answer"]) == strtolower($row["answer"])){
$updateCommand = "UPDATE exams_scores SET final_comment='correct' , score_point='1' WHERE script_owner='$owner' AND attempted_num='$id' LIMIT 1";
$updateQuery = mysqli_query($con,$updateCommand);
if(!$updateQuery){
$msg="Failed to Update option 1";
echo $msg;
}
else{
include("option_validator.php");
}}
else{
$updateCommand = "UPDATE exams_scores SET final_comment='wrong' , score_point='0' WHERE script_owner='$owner' AND attempted_num='$id' LIMIT 1";
$updateQuery = mysqli_query($con,$updateCommand);
if(!$updateQuery){
$msg="Failed to Update option 2";
echo $msg;
}
else{
include("option_validator_se.php");
}
}
}*******/
?>
