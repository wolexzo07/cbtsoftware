<?php
	if(!isset($tokenizer)){
		echo "Parameter missing for <b>fees</b> file";
		exit();
	}
	// Handling student school fee payments started

	$p = x_getsingleupdate("fee_data","status","id='1'");
	
	// validating if school fees payment checker for each student is activated
	
	if($p == "enabled"){
		
	if(x_count("fee_status","user ='$login' LIMIT 1") > 0){
	
		// handling fees part payments
	
		$allow_status = x_getsingleupdate("fee_data","allow_part_payment","id='1'");
		$allow_percent = x_getsingleupdate("fee_data","allowed_percent","id='1'");
	
		foreach(x_select("amount_paid,amount_to_pay","fee_status","user ='$login'","1","id") as $feth){
			$amount_paid = $feth["amount_paid"];
			$amt_t_p = $feth["amount_to_pay"];
			$calc = ($allow_percent/100) * $amt_t_p ; // calculating fees part payment
			
			if($allow_status == "yes"){
				
				if($amount_paid < round($calc,2)){
					
					$msg="Access Denied! Please complete your school fees payment.";
					
					finish("login-page","$msg");
					exit();
				}
				
			}
			
			if($allow_status == "no"){
				
				if($amount_paid != $amt_t_p){
					
					$msg="Access Denied! Please complete your school fees payment";
					
					finish("login-page","$msg");
					exit();
				}
				
			}
			
			
			
		}
		
		
	}else{
		$msg="Access Denied! School fees payment record not found.";
		finish("login-page?msg=$msg","$msg");
		exit();
	}
	
	}
		// Handling student school fee payments ended
	
	?>