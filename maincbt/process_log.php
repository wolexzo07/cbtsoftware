<?php
session_start();
include("finishit.php");
$tokenizer = sha1(uniqid());
if(x_validatepost("mat") && x_validatepost("pass")){

	$create = x_dbtab("usertimer","
	user VARCHAR(255) NOT NULL,
	token TEXT NOT NULL,
	start_time VARCHAR(255) NOT NULL,
	stop_time VARCHAR(255) NOT NULL, 
	currentime VARCHAR(255) NOT NULL 
	","MyISAM");
	
	if(!$create){
		finish("./","Failed to create table!");
		exit();
	}
	

	$login = x_clean(x_post("mat"));
	
	$salt = "wolexzo07dacrackertheBlAcKerhathacker199019921962";
	$password = X_clean(md5(sha1(x_post("pass").$salt)));
	
	include("fees.php"); // fees authentication begins b4 taking exams
	
	// Revoking access of user account
	
	if(x_count("register","username ='$login' AND Password = '$password' AND access = 'revoked' LIMIT 1") > 0){
		finish("login-page","Account temporarily suspended! Try again or contact ICT Department");
		exit();
	}
	
	// Validating login access
	
	if(x_count("register","username ='$login' AND Password = '$password' AND access = 'granted' LIMIT 1") > 0){

			// Fetching the current user data			
			foreach(x_select("0","register","username ='$login' AND Password = '$password' AND access = 'granted'","1","id") as $user){
				
				$_SESSION['SESS_D_MEMBER_ID_EXAM'] = $user['id'];
				$_SESSION['SESS_D_NAME_EXAM'] = $user['Name'];
				$_SESSION['SESS_D_USER_EXAM'] = $user['username'];
				$_SESSION['SESS_D_LEVEL_EXAM'] = $user['Level'];
				$_SESSION['SESS_D_DEPT_EXAM'] = $user['Department'];
				$_SESSION['SESS_D_TITLE_EXAM'] = $user['title'];
				$_SESSION['SESS_D_EMAIL_EXAM'] = $user['email'];
				$_SESSION['SESS_D_MOBILE_EXAM'] = $user['mobile'];
				$_SESSION['SESS_D_GENDER_EXAM'] = $user['Gender'];
				$_SESSION['SESS_D_MAT_NO_EXAM'] = $user['Admission_No'];
				$_SESSION['SESS_BLIV'] = sha1(uniqid()).sha1(rand(4 , 9300000));
				$_SESSION['HTTP_IUOCBT'] = xip(); 
				$_SESSION['OPERATING_SYSTEM_IUOCBT'] = xos();
				
			}
			
			include("choice.php");
			session_write_close();
		
			include("time_logon.php");
			
			finish("./","0");
		}
		else {
		
			finish("login-page","Username or password incorrect!!");
		
		}
}
else{
		finish("login-page","Parameter");
}

?>
