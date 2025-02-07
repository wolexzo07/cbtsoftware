<?php
	function x_getBankLists($country){ // Get the list of banks by country

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/banks/$country"; // NG, GH, KE, UG, ZA or TZ.

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


	function x_getBankBranch($bankid){ // Get the list of banks branch by country

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/banks/$bankid/branches"; // Bank's unique ID

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