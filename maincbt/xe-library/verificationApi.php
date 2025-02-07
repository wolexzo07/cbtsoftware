<?php
	
	function x_initiateBVN($bvn , $first , $last){ // Initiate BVN consent
		
		$apiEndpoint = 'https://api.flutterwave.com/v3/bvn/verifications';
		
		$secretKey = x_getFlwKey("live" , "s");	
		
		$authorizationToken = "$secretKey";

		$data = [
			"bvn" => "$bvn",
			"firstname" => "$first", 
			"lastname" => "$last",
		];

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
	
	
	function x_veriBvnC($reference){ // Verify BVN consent

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/bvn/verifications/$reference"; 

		$ch = curl_init($apiEndpoint);

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
	
	
	function x_veriBankAcct($bvn , $first , $last){ // Verify bank account
		
		$apiEndpoint = 'https://api.flutterwave.com/v3/accounts/resolve';
		
		$secretKey = x_getFlwKey("live" , "s");	
		
		$authorizationToken = "$secretKey";

		$data = [
			"account_number" => "$bvn",
			"account_bank" => "$bankcode", 
			"country" => "$country", // NG, KE and US
		];

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
	
	
	function x_veriBin($bin){ // Verify card BIN

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/card-bins/$bin"; // BIN = 6-digits on card

		$ch = curl_init($apiEndpoint);

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