<?php
// Fixed account creation

	function x_createFixedBloc($cid , $pfbk , $alias , $cr , $amt , $freq){ // Creating account

			$apiEndpoint = "https://api.blochq.io/v1/accounts";
			
			$secretKey = x_getBlocKey("live" , "s");	
			
			$authorizationToken = "$secretKey";
			
			$allowed = ["1","0"];
			
			if(!in_array($cr , $allowed)){
				return "Collection rule option is invalid (0 , 1)";
				exit();
			}
			
			if($cr == "1"){
				
				$crDetails = [
					"amount" => $amt,
					"frequency" => $freq, 
				];
				
				$data = [
					"customer_id" => "$cid",
					"preferred_bank" => "$pfbk", 
					"alias" => "$alias",
					"collection_rules" => $crDetails,
				];
				
			}else{
				
				$data = [
				"customer_id" => "$cid",
				"preferred_bank" => "$pfbk", 
				"alias" => "$alias",
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
	
	
	
	function x_getAllBlocAccounts($option , $acctid , $acctnumb , $cusID){ // Get accounts by id and number
	
		$secretKey = x_getBlocKey("live" , "s");	
		
		$apiEndpoint = "https://api.blochq.io/v1/accounts";
		
		if($option == "id"){ // get by account ID
		
			$apiEndpoint = "https://api.blochq.io/v1/accounts/$acctid";
		
		}

		if($option == "acctnumb"){ // get by account number
			
			$apiEndpoint = "https://api.blochq.io/v1/accounts/number/$acctnumb";
			
		}
		
		if($option == "custid"){ // get by customer id
			
			$apiEndpoint = "https://api.blochq.io/v1/accounts/customers/accounts/$cusID";
			
		}
		
		if($option == "orgacct"){ // Get Organisation Default Accounts
			
			$apiEndpoint = "https://api.blochq.io/v1/accounts/organization/default";
			
		}

		//$queryString = http_build_query($queryParams);
		//$ch = curl_init($apiEndpoint . '?' . $queryString);
		
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
	
	
	
	function x_manageBlocAcct($opt , $acctID , $reason){ // Freeze , unfreeze , close and Re-open
	
		if($opt == "freeze"){ // freeze account
			
			$apiEndpoint = "https://api.blochq.io/v1/accounts/$acctID/freeze";
		
		}
		
		if($opt == "unfreeze"){ // unfreeze account
			
			$apiEndpoint = "https://api.blochq.io/v1/accounts/$acctID/unfreeze";
		
		}

		if($opt == "close"){ // close account
			
			$apiEndpoint = "https://api.blochq.io/v1/accounts/$acctID/close";
		
		}

		if($opt == "reopen"){ // re-open account
			
			$apiEndpoint = " https://api.blochq.io/v1/accounts/$acctID/reopen";

		}
		
		$data = [
		
			"reason" => "$reason"

		];
		
		$secretKey = x_getBlocKey("live" , "s");
		
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
		  CURLOPT_POSTFIELDS => $data,
		  CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json",
			"Authorization: Bearer $authorizationToken"
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



// Collection account creation

	 // https://api.blochq.io/v1/accounts/collections   | POST  | create collection account
	 //  https://api.blochq.io/v1/accounts/collections   | GET | Get colection account

?>