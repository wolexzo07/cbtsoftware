<?php

	function x_genSubAccounts($country , $email , $trxref , $mobile , $firstname , $lastname , $bank_code){ // Generate sub accounts
		
		$apiEndpoint = "https://api.flutterwave.com/v3/payout-subaccounts";
		
		$secretKey = x_getFlwKey("live" , "s");	
		
		$authorizationToken = "$secretKey";

		$data = [
			"account_name" => "$lastname $firstname",
			"email" => "$email",
			"mobilenumber" => "$mobile",
			"country" => "$country",
			"account_reference" => "$trxref", // optional
			"bank_code" => "$bank_code",  // 035 (Wema bank) and 232(Sterling bank) | optional
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
	
	function x_listSubAccounts($skipall , $account_reference , $email , $nuban , $limit , $nextcursor){ // List all payout subaccounts

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/payout-subaccounts";
		
		
		if($skipall  == "1"){
			
			$ch = curl_init($apiEndpoint);
			
		}else{

			$queryParams = [ // parameter is optional 
					"email" => "$email",
					"account_reference" => "$account_reference",
					"nuban" => "$nuban",
					"limit" => "$limit", // specify number of wallet entries
					"next_cursor" => "$nextcursor", // next cursor
			];
			
			$queryString = http_build_query($queryParams);
			$ch = curl_init($apiEndpoint . '?' . $queryString);
		}


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
	
	function x_getSubAccount($account_reference){ // Fetch accounts by Reference

		$secretKey = x_getFlwKey("live" , "s");
		
		$apiEndpoint = "https://api.flutterwave.com/v3/payout-subaccounts/$account_reference";
		
		$queryParams = [
				"code" => "$biller_code", // biller code
				"customer" => "$customerid", // customer identifier
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

	
	function x_updateWDetails($account_reference , $account_name , $mnum , $email){ // update subaccount wallet details
	
		$apiEndpoint = "https://api.flutterwave.com/v3/payout-subaccounts/$account_reference";
		
		$secretKey = x_getFlwKey("live" , "s");	
		
		$authorizationToken = "$secretKey";
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "$apiEndpoint",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'PUT',
		  CURLOPT_POSTFIELDS =>"{
			'account_name': '$account_name',
			'mobilenumber': '$mnum',
			'email': '$email'
		}",
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Authorization: Bearer $authorizationToken'
		  ),
		));

		$response = curl_exec($curl);

		if(curl_errno($curl)){
			
			$apiresponse = 'cURL Error: ' . curl_error($curl);
			
		}else{

			$apiresponse = $response;
		}

		curl_close($curl);
		
		return $apiresponse;
	}
	

	function x_fetchTranxlogs($account_reference , $currency , $from , $to){ // Fetch transaction logs for NGN USD GBP EUR

		$secretKey = x_getFlwKey("live" , "s");
		
		$apiEndpoint = "https://api.flutterwave.com/v3/payout-subaccounts/$account_reference/transactions";
		
		$queryParams = [
				"from" => "$from", // from date
				"to" => "$to", // to date
				"currency" => "$currency", // USD , GBP , EUR , NGN
				"page" => "1", // optional | retrieves first page
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
	
	
	function x_fetchBalance($account_reference , $currency){ // Fetch account available balance

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/payout-subaccounts/$account_reference/balances";
		
		$queryParams = [
				"currency" => "$currency", // USD , GBP , EUR , NGN
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
	
	
	function x_getStaticAcct($account_reference , $currency){ // Creating virtual accounts for USD GBP EUR

		$secretKey = x_getFlwKey("live" , "s");	
		
		$apiEndpoint = "https://api.flutterwave.com/v3/payout-subaccounts/$account_reference/static-account";
		
		$queryParams = [
				"currency" => "$currency", // USD , GBP , EUR
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