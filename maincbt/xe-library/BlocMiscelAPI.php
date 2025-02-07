<?php
	function x_getBlocMisc($opt , $acctnumb ,$bnkcode , $cp){ // Get bloc miscellaneous
	
		$secretKey = x_getBlocKey("live" , "s");	
		
		if($opt == "blist"){ // Bank listing
		
			$apiEndpoint = "https://api.blochq.io/v1/banks";
			
		}

		if($opt == "resolve"){ // Resolving account
		
			$apiEndpoint = "https://api.blochq.io/v1/resolve-account";
			
			$queryParams = [
					"account_number" => "$acctnumb",
					"bank_code" => "$bnkcode",
				];
			
		}

		if($opt == "rates"){ // Exchange rates
			
			$apiEndpoint = "https://api.blochq.io/v1/rates/currencies/$cp";
			
		}
		
		if(isset($queryParams)){
			
			$queryString = http_build_query($queryParams);
			
			$ch = curl_init($apiEndpoint . '?' . $queryString);
			
		}else{
			
			$ch = curl_init($apiEndpoint);
			
		}

		$authorizationHeader = "Authorization: Bearer $secretKey";
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [$authorizationHeader]);

		$response = curl_exec($ch);

		if(curl_errno($ch)){
			
			$apiresponse = 'cURL Error: ' . curl_error($ch);
			
		}else{

			$apiresponse = $response;
		}

		curl_close($ch);
		
		return $apiresponse;
	
	}
	
	
	function x_setBlocWebHook($url){ // Set webhook
		
		$secretKey = x_getBlocKey("live" , "s");	
		
		$authorizationToken = "$secretKey";
		
		$apiEndpoint = " https://api.blochq.io/v1/webhooks";
			
		$data = [
					"url" => "$url",
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
	
	
	function x_getBlocWebHook(){ // Get bloc webHooks
	
		$secretKey = x_getBlocKey("live" , "s");	
		
		$apiEndpoint = "https://api.blochq.io/v1/webhooks";

		$ch = curl_init($apiEndpoint);

		$authorizationHeader = "Authorization: Bearer $secretKey";
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [$authorizationHeader]);

		$response = curl_exec($ch);

		if(curl_errno($ch)){
			
			$apiresponse = 'cURL Error: ' . curl_error($ch);
			
		}else{

			$apiresponse = $response;
		}

		curl_close($ch);
		
		return $apiresponse;
	
	}
?>