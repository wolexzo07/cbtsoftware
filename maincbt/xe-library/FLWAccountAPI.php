<?php
	
	function x_FlwBalByCur($currency){ // Fetch balance by currency

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/balances/$currency"; 

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
	

	function x_FlwBalAll(){ // Fetch all balances

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/balances"; 

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


	function x_FlwHistory($skipall , $from , $to , $cur , $fm , $type , $page){ // Fetch your wallet's transaction history.

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/wallet/statement"; 
		
		
		if($skipall == "1") {
			
			$queryParams = [
				"from" => "$from", // from date YYYY-MM-DD.
				"to" => "$to", // to date YYYY-MM-DD.
				"currency" => "$cur", // wallet currency
				"force_merged" => $fm, // true or false  | retrieve the wallet statement of only your available balance.
				"type" => "$type", // C or D (where C means Credit and D means Debit).
				"page" => $page, // page number to retrieve i.e. setting 1 retrieves the first page.
			];
		
			$queryString = http_build_query($queryParams);
			$ch = curl_init($apiEndpoint . '?' . $queryString);
			
		} else {
			
			$ch = curl_init($apiEndpoint);
			
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
	
	// Settlement api

	function x_FlwFSettlement($skipall , $from , $to , $page , $subid){ // Fetch settlements.

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/wallet/statement"; 
		
		
		if($skipall == "1") {
			
			$queryParams = [
				"from" => "$from", // from date YYYY-MM-DD.
				"to" => "$to", // to date YYYY-MM-DD.
				"page" => $page, // page number to retrieve i.e. setting 1 retrieves the first page.
				"subaccount_id" => $subid, // unique id of the sub account
			];
		
			$queryString = http_build_query($queryParams);
			$ch = curl_init($apiEndpoint . '?' . $queryString);
			
		} else {
			
			$ch = curl_init($apiEndpoint);
			
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
	
	
	
	function x_GetaSettlement($skipall , $settlementid , $from , $to){ // Fetch settlements by id.

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/settlements/$settlementid"; 
		
		
		if($skipall == "1") {
			
			$queryParams = [
				"from" => "$from", // from date YYYY-MM-DD.
				"to" => "$to", // to date YYYY-MM-DD.
			];
		
			$queryString = http_build_query($queryParams);
			$ch = curl_init($apiEndpoint . '?' . $queryString);
			
		} else {
			
			$ch = curl_init($apiEndpoint);
			
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
	
?>