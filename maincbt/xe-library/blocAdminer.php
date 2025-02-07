<?php
 
 function bp_sessionChecker(){

		if(x_validatesession("BILL_PILOT_TOKEN") && x_validatesession("BILL_PILOT_ID")){
			
			$response = "yes";
			
		}else{
			
			$response = "no";
			
		}
		
		return $response;
	
 }


?>