<?php
session_start();

include("xe-library/xe-library74.php");

if(x_validatepost("token") && x_validatepost("qtoken")){
	
	if(!isset($_SESSION['SESS_D_USER_EXAM'])){

		finish("logout","0");

		exit;
	}

	$pager= x_post("cnum"); $loc = x_get("loc"); $timer = x_curtime(0,1); 


	if(x_count("portal","id='1' AND portal_status='closed' LIMIT 1") > 0){
		
		$msg="Examination portal closed!";
		
		finish("$loc","$msg");
		
		exit();
	}

	if(x_count("cross_platform_mode","id='1' AND status='enable' LIMIT 1") > 0){
		
		if(isset($_SESSION['EXAM_RESULT_STOPPED'])){
			
			$msg="You cannot continue this exam because your result is already published!!";
			
			finish("$loc","$msg");
			
			exit();
		}
	}


	$user_acct = $_SESSION['SESS_D_USER_EXAM']; $email_acct = $_SESSION['SESS_D_EMAIL_EXAM'];
	
	if(x_count("register","username='$user_acct' AND access='revoked' LIMIT 1") > 0){
		
		$msg="Please you cannot continue this exam";
		
		$pager= $_POST["cnum"];

		finish("$loc","$msg");
		
	}else{

		$owner = $_SESSION['SESS_D_USER_EXAM']; $full = $_SESSION['SESS_D_NAME_EXAM']; $email = $_SESSION['SESS_D_EMAIL_EXAM'];
		
		$ip = xip(); $os = xos(); $browser = xbr();

		$token = xp("token"); $qtoken = xp("qtoken"); $id = xp("id"); $etype = xp("type"); $cat = xp("cat"); $pager= xp("cnum");

		foreach($_POST['ans'] as $units){
			
			$post[] = $units;

			if($units == null){
				
				finish("$loc","0");
				
				exit();
				
			}
		}

		$arr = x_clean(strtolower(implode("-" , $post)));
		
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
			score_approval TEXT NOT NULL,
			ip_address TEXT NOT NULL ,
			os TEXT NOT NULL ,
			browser TEXT NOT NULL ,
			date_time DATETIME NOT NULL ,
			token TEXT NOT NULL 
		","innoDB");

		if(!$tab){
			
			$msg="Failed to Create table in the database! Pls try again";
			
			finish("$loc","$msg");
			
			exit();
		}
		
		
		$getAnswer = x_getsingleresult("questions","answer","approval_status='approved' AND id='$id'");
			
		$correct_ans = strtolower($getAnswer);
			
		$m_ans = explode(",",$getAnswer); // getting correct answer from db
		
		if(x_count("exams_scores","attempted_num='$id' AND ques_token='$qtoken' AND script_owner='$owner' LIMIT 1") > 0){
			
			if(x_count("option_update","id='1' AND status='Disallow' LIMIT 1") > 0){
	
				$msg = "Please you cannot update your answer";
				
				finish("$loc","$msg");
				
				exit();
			}
			
			if(in_array($arr ,$m_ans)){
				
				$failed = "Failed to insert correct data!";
				
				x_updated("exams_scores","attempted_num='$id' AND ques_token='$qtoken' AND script_owner='$owner'","final_comment='correct' ,score_point='1' , answer='$arr'","<script>window.location='$loc';</script>","<script>alert('$failed');window.location='$loc';</script>");

			}else{
				
				$failed = "Failed to insert correct data!";
				
				x_updated("exams_scores","attempted_num='$id' AND ques_token='$qtoken' AND script_owner='$owner'","final_comment='wrong' ,score_point='0' , answer='$arr'","<script>window.location='$loc';</script>","<script>alert('$failed');window.location='$loc';</script>");
				
			}
			
			
		}else{
			
				if(in_array($arr ,$m_ans)){

					$failed = "Failed to insert correct data!";
					
					x_insert("fullname , script_owner , owner_email , exam_type , subject , answer , correct_ans , attempted_num , ques_token , final_comment ,score_point , score_approval , ip_address , OS , browser , date_time , token","exams_scores","'$full' ,'$owner' , '$email' ,'$etype' ,'$cat' , '$arr' , '$correct_ans' , '$id' ,'$qtoken' , 'correct' , '1' ,'pending' ,'$ip' ,'$os' ,'$browser' ,'$timer','$token'","<script>window.location='$loc';</script>","<script>alert('$failed');window.location='$loc';</script>");

				}else{
					
					$failed = "Failed to insert correct data!";
					
					x_insert("fullname , script_owner , owner_email , exam_type , subject , answer , correct_ans , attempted_num , ques_token , final_comment ,score_point , score_approval , ip_address , OS , browser , date_time , token","exams_scores","'$full' ,'$owner' , '$email' ,'$etype' ,'$cat' , '$arr' , '$correct_ans' , '$id' ,'$qtoken' , 'wrong' , '0' ,'pending' ,'$ip' ,'$os' ,'$browser' , '$timer' ,'$token'","<script>window.location='$loc';</script>","<script>alert('$failed');window.location='$loc';</script>");
					
				}
			
		} // continue from here

}

}else{
		$msg = "Parameter Missing!";
		
		finish("$loc","$msg");
}
?>
