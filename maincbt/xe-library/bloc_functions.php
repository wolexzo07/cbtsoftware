<?php
//include_once("xe-library/xe-library74.php");

function x_checklocalremotebal($wtoken , $utoken){
	
	$acctnumb = x_getauserAccountnumber("$wtoken" ,"$utoken");

	$remote_balance = x_getBlocAvBalAcctID("$acctnumb" , "1");
	
	$local_balance = x_getauserlocalBalance("$wtoken");
	
	if($remote_balance == $local_balance){
		
		$response = "1";
		
	}else{
		
		$response = "0";
		
	}
	
	return $response;
	
}

function x_transferFromUserToOrg($wtoken , $utoken , $amount , $note){ // Transfer from user to company
	
	 $to_acctid = x_getBlocAvBalAcctID("8733631440" , "0"); // company acct id
											 
	 $useraccount = x_getauserAccountnumber("$wtoken" ,"$utoken");
	 
	 $from_acctid = x_getBlocAvBalAcctID("$useraccount" , "0"); // user account id
	 
	 if($note = ""){
		 
		 $note = "Fee transfer from user to company";
		 
	 }else{
		 
		 $note = $note;
		 
	 }
	 
	 $ref = md5(uniqid().str_shuffle($to_acctid.DATE("YmdHis")));
	 
	 $create = x_BlocInternalTranfer($amount,$from_acctid,$to_acctid,$note,$ref);
	 
	 $data = json_decode($create , true);
	 
	 if(isset($data["success"])){
		 
		 if($data["success"] == "1"){
			 
			 return "1"; // Transfer made successfully
			 
		 }else{
			 
			 return "0"; // Failed making transfer
			 
		 }
		 
	 }
	
}

function x_transferFromOrgToUser($wtoken , $utoken , $amount , $note){ // Transfer from user to company
	
	 $from_acctid = x_getBlocAvBalAcctID("8733631440" , "0"); // company acct id
											 
	 $useraccount = x_getauserAccountnumber("$wtoken" ,"$utoken");
	 
	 $to_acctid = x_getBlocAvBalAcctID("$useraccount" , "0"); // user account id
	 
	 if($note = ""){
		 
		 $note = "Fee transfer from company to user";
		 
	 }else{
		 
		 $note = $note;
		 
	 }
	 
	 $ref = md5(uniqid().str_shuffle($to_acctid.DATE("YmdHis")));
	 
	 $create = x_BlocInternalTranfer($amount,$from_acctid,$to_acctid,$note,$ref);
	 
	 $data = json_decode($create , true);
	 
	 if(isset($data["success"])){
		 
		 if($data["success"] == "1"){
			 
			 return "1"; // Transfer made successfully
			 
		 }else{
			 
			 return "0"; // Failed making transfer
			 
		 }
		 
	 }
	
}

function x_getBlocAvBalAcctID($acctnumb , $opt){ // GET account balance and account id

	$allowed = ["0","1","2","all"];
	
	if(!in_array($opt , $allowed)){
		
		echo "Invalid option (0-2 | all)";
		
		exit();
		
	}else{
		
			$option = "acctnumb"; $acctid = "";$cusID = "";

			$data = x_getAllBlocAccounts($option , $acctid , $acctnumb , $cusID);

			$decode = json_decode($data , true);

			if(isset($decode["success"])){
				
				if($decode["success"] == "1"){
					
					if(isset($decode["data"])){
						
						$company_account_id = $decode["data"]["id"];
						
						$company_balance = $decode["data"]["balance"] / 100;
						
						$company_av_balance = $decode["data"]["available_balance"] / 100;
						
						if($opt == "0"){
							
							return $company_account_id;
							
						}
						
						if($opt == "1"){
							
							return $company_av_balance;
							
						}
						
						if($opt == "2"){
							
							return $company_balance;
							
						}
						
						if($opt == "all"){
							
							return $company_account_id."===".$company_av_balance."===".$company_balance;
							
						}
						
						
					}
					
				}
				
			}
		
	}

}


function  x_checkingForSufficiency($wtoken , $amount){
	
	$balance = x_getauserlocalBalance($wtoken);
	
	if($amount > $balance){
		
		return "0"; // for insufficient balance
		
	}
	
}

function x_getauserAccountnumber($wtoken ,$utoken){ // get a user account number

	$account_number = x_getsingleupdate("banking_details","account_number","wtoken='$wtoken' AND utoken='$utoken'");
	
	return $account_number;
	
}


function x_getauserlocalBalance($wtoken){ // get a user local balance

	$balance = x_getsingleupdate("bpilot_wallets","wallet_ngn","wtoken='$wtoken'");
	
	return $balance;
	
}


function x_blocTransferFees($amount){ // 
	
	if($amount <= 5000){
		
		$extra_charges = 15; // Our own charge
		
		$charges = 10; // bloc charge
		
		$total = $charges + $extra_charges; 
		
	}elseif($amount > 5000 && $amount <= 50000){
		
		$extra_charges = 15;
		
		$charges = 20;
		
		$total = $charges + $extra_charges; 
		
	}elseif($amount > 50000){
		
		$extra_charges = 8;
		
		$charges = 45;
		
		$total = $charges + $extra_charges; 
		
	}else{
		
		$extra_charges = 0;
		
		$charges = 0;
		
		$total = $charges + $extra_charges; 
		
	}
	
	return $total;
	
}

?>