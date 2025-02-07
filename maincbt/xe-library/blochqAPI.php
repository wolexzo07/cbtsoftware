<?php
	
	include_once("blocIntegration.php");
	include_once("blochqBillsPaymentsAPI.php");
	include_once("blochqVirtualAccountsApi.php");
	include_once("BlocCardApi.php");
	include_once("BlocMiscelAPI.php");
	include_once("customerBlocApi.php");
	include_once("BlocTransferApi.php");
	include_once("bloc_functions.php");


	function x_getBlocKey($liveortest , $switch){
		
		$allowed = ["live","test"];
		$allowedswitch = ["p","s"]; // secret | public | encryption
		
		if(in_array($liveortest,$allowed) && in_array($switch,$allowedswitch)){
			
			if($switch == "s"){
				
				$type = "secretkey";
				
			}
			
			if($switch == "p"){
				
				$type = "publickey";
				
			}
			
			$getKey = x_getsingleupdate("paymentkeys","$type","company='bloc' AND statustype='$liveortest'");
			
			$response = $getKey;
		}
		
		return $response;
		
	}
?>