<?php
  include("auth.php");
	$tok = sha1(uniqid(rand(278,23000)));
	$agent = xbr();
	$ip = xip();
	$user = $_SESSION['SESS_D_USER_EXAM'];
	$sess = "true";
	$cur_dat = DATE("Y-m-d");

	if(x_validatesession("EXAM_RESULT_STOPPED")){
		unset($_SESSION['EXAM_RESULT_STOPPED']);
		finish("selection_page?active_session=true&generated_token=$tok&user_agent=$agent&current_user=$user&current_ipAddr=$ip","0");
	}
	else{	      
		finish("selection_page?active_session=true&generated_token=$tok&user_agent=$agent&current_user=$user&current_ipAddr=$ip","0");
	}

?>