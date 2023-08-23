<?php
	if(!isset($tokenizer)){
			echo "Token missing for <b>acct_suspender</b> file";
			exit();
	}
	
	$user_acct = x_clean(x_session("SESS_D_USER_EXAM"));
	$p_acct = x_getsingleupdate("register","access","username='$user_acct'");

	if($p_acct == "revoked"){
		$msg="<b>Access Denied! because your result is published</b>";
		echo $msg;
		exit();
	}
?>