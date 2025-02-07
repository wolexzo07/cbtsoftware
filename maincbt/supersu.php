<?php
	
	if(x_validatesession("TIMBOSS_CRYPTBUY_ID")){
			
			$uid = $_SESSION["TIMBOSS_CRYPTBUY_ID"];
	
			if(sh_adminchecker($uid) == "0"){
				
				x_toasts("Access denied! Escalate privilege");
				
				exit();
			}
	
	}

?>