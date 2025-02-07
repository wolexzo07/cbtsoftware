<?php

	function x_createTransferFlw($type , $bankcode ,$acctnumb , $amount , $note , $dbcur , $callback , $ref , $routnum , $swift , $bankname , $bname , $addr , $bcount , $pcode , $stnumb , $stname , $city){ // Initiate Transfers
		
		$apiEndpoint = "https://api.flutterwave.com/v3/transfers";
		
		$secretKey = x_getFlwKey("live" , "s");	
		
		$authorizationToken = "$secretKey";

		if($type == "NGN"){ // For transfer to other Nigeria Banks
			
			$data = [
				"account_bank" => "$bankcode", // Bank code
				"account_number" => "$acctnumb", // Account number
				"amount" => "$amount", // Amount to transfer
				"currency" => "NGN",
				"narration" => "$note",
				"debit_currency" => "$dbcur",
				"callback_url" => "$callback",
				"reference" => "$ref" // unique reference by developer
			];
			
		}
		
		if($type == "USD"){ // For transfer to other US bank account
		
			$meta = [
				  "account_number" => "$acctnumb",
				  "routing_number" => "$routnum",
				  "swift_code" => "$swift",
				  "bank_name" => "$bankname",
				  "beneficiary_name" => "$bname",
				  "beneficiary_address" => "$addr",
				  "beneficiary_country" => "$bcount"
			];
			
			$data = [
				"amount" => "$amount",
				"narration" => "$note",
				"currency" => "USD",
				"reference" => "$ref",
				"beneficiary_name" => "$bname",
				"meta" => $meta,
			];
	
		}


		if($type == "GBP" || $type == "EUR"){ // For transfer to GBP or EUR bank account
		
			$meta = [
				  "account_number" => "$acctnumb",
				  "routing_number" => "$routnum",
				  "swift_code" => "$swift",
				  "bank_name" => "$bankname",
				  "beneficiary_name" => "$bname",
				  "beneficiary_country" => "$bcount",
				  "postal_code" => "$pcode", 
				  "street_number" => "$stnumb",
				  "street_name" => "$stname",
				  "city" => "$city"
			];
			
			$data = [
				"amount" => "$amount",
				"narration" => "$note",
				"currency" => "$type",
				"reference" => "$ref",
				"beneficiary_name" => "$bname",
				"meta" => $meta,
			];
	
		}
		

		$jsonData = json_encode($data);
		
		$ch = curl_init($apiEndpoint);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Authorization: Bearer ' . $authorizationToken,
			'Content-Type: application/json',
		]);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

		$response = curl_exec($ch);

		if(curl_errno($ch)){
			
			$apiresponse = 'cURL Error: ' . curl_error($ch);
			
		}else{

			$apiresponse = $response;
		}

		curl_close($ch);
		
		return $apiresponse;

	}
	
	
	function x_retryTransfer($transferid){ // Retries Transfers using unique_id
		
		$apiEndpoint = "https://api.flutterwave.com/v3/transfers/$transferid/retries";
		
		$secretKey = x_getFlwKey("live" , "s");	
		
		$authorizationToken = "$secretKey";

		$jsonData = "";
		
		$ch = curl_init($apiEndpoint);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Authorization: Bearer ' . $authorizationToken,
			'Content-Type: application/json',
		]);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

		$response = curl_exec($ch);

		if(curl_errno($ch)){
			
			$apiresponse = 'cURL Error: ' . curl_error($ch);
			
		}else{

			$apiresponse = $response;
		}

		curl_close($ch);
		
		return $apiresponse;

	}
	
	
	function x_getTransferFee($amount , $currency){ // Get transfer fee in different currency

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/transfers/fee";
		
		$queryParams = [  
				"amount" => "$amount",
				"currency" => "$currency", // NGN, USD, GHS, KES, UGX, RWF.
		];
		
		$queryString = http_build_query($queryParams);
		$ch = curl_init($apiEndpoint . '?' . $queryString);

		$authorizationHeader = "Authorization: Bearer $secretKey";
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [$authorizationHeader]);

		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			
			$apiresponse = 'cURL Error: ' . curl_error($ch);
			
		} else {

			$apiresponse = $response;
		}

		curl_close($ch);
		
		return $apiresponse;	
		
	}

?>