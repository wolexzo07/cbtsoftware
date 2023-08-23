<?php
session_start();
include("finishit.php");
if(x_validatesession("SESS_D_USER_EXAM")){
 
 $user = x_session("SESS_D_USER_EXAM");
  
 if(x_count("logoff_users","username='$user' AND status='granted'") > 0){
	        
			unset($_SESSION['SESS_D_MEMBER_ID_EXAM']);
			unset($_SESSION['SESS_D_NAME_EXAM']);
			unset($_SESSION['SESS_D_USER_EXAM']);
			unset($_SESSION['SESS_D_LEVEL_EXAM']);
			unset($_SESSION['SESS_D_DEPT_EXAM']);
			unset($_SESSION['SESS_D_TITLE_EXAM']) ;
			unset($_SESSION['SESS_D_EMAIL_EXAM']);
			unset($_SESSION['SESS_D_MOBILE_EXAM']);
			unset($_SESSION['SESS_D_GENDER_EXAM']);
			unset($_SESSION['SESS_D_MAT_NO_EXAM']) ;
			unset($_SESSION['SESS_D_EXAM_BUTTON_MA']);
			unset($_SESSION['SESS_D_EXAM__RAND_TOKEN']);
	        unset($_SESSION['course_session']);
			
			if(x_validatesession("EXAM_RESULT_STOPPED")){
				unset($_SESSION['EXAM_RESULT_STOPPED']);
				}
 }

}	
?>
