<?php
	session_start();
	include_once("finishit.php");

	if(x_validatesession("SESS_D_USER_EXAM")){
		
		$tokenizer = sha1(uniqid());
		
	}else{
		$msg="<b style='color:red'>Your time has expired</b>";
		echo $msg;
		exit();
	}

	if(x_validateget("opt")){

	$id = xg("id");$opt = xg("opt");
	$typic = xg("typing");$to = xg("tokken");
	
	$subj = xg("subject");$eml = xg("emailer");
	
	$owner = x_clean(x_session("SESS_D_USER_EXAM"));
	$full = x_clean(x_session("SESS_D_NAME_EXAM"));
	
	$ip = xip();$os = xos();$browser = xbr();
	
	$token = sha1(md5(rand(0 ,9000000)).$owner.$id);

	$tab = x_dbtab("exams_scores","
	fullname TEXT NOT NULL , 
	script_owner TEXT NOT NULL ,
	owner_email TEXT NOT NULL,
	exam_type TEXT NOT NULL ,
	subject TEXT NOT NULL ,
	answer TEXT NOT NULL ,
	correct_ans TEXT NOT NULL,
	attempted_num TEXT NOT NULL , 
	ques_token TEXT NOT NULL,
	final_comment TEXT NOT NULL,
	score_point INT NOT NULL ,
	Score_approval TEXT NOT NULL,
	ip_address TEXT NOT NULL ,
	OS TEXT NOT NULL ,
	browser TEXT NOT NULL ,
	date_time DATETIME NOT NULL ,
	token TEXT NOT NULL","MYISAM");

	if(!$tab){
		echo "Failed to create scoring system!";
		exit();
	}
	
	include("stopit.php");
	include('time_out.php');
	include('portal_auth.php');
	include('acct_suspender.php');
	
	if(x_count("exams_scores","script_owner='$owner' AND attempted_num='$id' LIMIT 1") > 0){
		
		include_once("option_update_validator.php");
		
	}else{
		
		x_insert("fullname , script_owner ,owner_email, exam_type , subject ,answer ,attempted_num ,ques_token, score_approval , ip_address , OS , browser , date_time , token","exams_scores","'$full' ,'$owner' ,'$eml' , '$typic' ,'$subj', '$opt' ,'$id' ,'$to' , 'pending' ,'$ip' ,'$os' ,'$browser' , now() ,'$token'"," ","failed to upload data");
		
		include("valid.php");
	}

}
?>
