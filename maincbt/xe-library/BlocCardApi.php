<?php

 	function x_createBlocCard($cid , $brand){ // Issue Card

			$apiEndpoint = "https://api.blochq.io/v1/cards";
			
			$secretKey = x_getBlocKey("live" , "s");	
			
			$authorizationToken = "$secretKey";
			
			$data = [
					"customer_id" => "$cid",
					"brand" => "$brand", // MasterCard = USD | Verve = NGN
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
	
	
	function x_getBlocCardInfo($option , $cardID , $custID){ // Get Cards
	
		$secretKey = x_getBlocKey("live" , "s");	
		
		$apiEndpoint = " https://api.blochq.io/v1/cards"; // Just get cards
		
		if($option == "id"){ // get card by ID
		
			$apiEndpoint = " https://api.blochq.io/v1/cards/$cardID";
		
		}

		if($option == "custID"){ // get card by Customer ID
			
			$apiEndpoint = "https://api.blochq.io/v1/cards/customer/$custID";
			
		}
		
		if($option == "csdata"){ // Get Card Secure Data
			
			$apiEndpoint = "https://api.blochq.io/v1/cards/secure-data/$cardID";
			
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
	

	function x_manageBlocCard($cardID , $acctid , $reason){ // Manage card
	
		if($opt == "chpin"){ // change card pin
			
			$apiEndpoint = "https://api.blochq.io/v1/cards/change-pin/$cardID";
			
			$data = [
						"old_pin" => "$old",
						"new_pin" => "$new"
				];
		}
		
		if($opt == "freeze"){ // freeze card
			
			$apiEndpoint = " https://api.blochq.io/v1/cards/freeze/$cardID";
			
			$data = "";
		}

		if($opt == "unfreeze"){ // unfreeze card
			
			$apiEndpoint = "https://api.blochq.io/v1/cards/unfreeze/$cardID";
			
			$data = "";
		
		}

		if($opt == "block"){ // block card
			
			$apiEndpoint = "https://api.blochq.io/v1/cards/block/$cardID";
			
			$data = [
						"account_id" => "$acctid",
						"reason" => "$reason"
				];

		}
		
		if($opt == "linkcard"){ // Link Card with Fixed Account
			
			$apiEndpoint = "https://api.blochq.io/v1/cards/fixed-account/link";
			
			$data = [
						"card_id" => "$cardID",
						"account_id" => "$acctid"
				];

		}


		if($opt == "unlinkcard"){ // UnLink Card with Fixed Account
			
			$apiEndpoint = "https://api.blochq.io/v1/cards/fixed-account/unlink/$cardID";
			
			$data = "";
		}
		
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
	
	
	function x_fwBlocCard($opt , $cardID , $acctid , $cur){ // Card funding / withdrawal
		
		$secretKey = x_getBlocKey("live" , "s");	
		
		$authorizationToken = "$secretKey";
		
		if($opt == "fundcard"){ //  Card funding
			
			$apiEndpoint = "https://api.blochq.io/v1/cards/fund/$cardID";
			
			$data = [
						"amount" => $amt,
						"from_account_id" => "$acctid",
						"currency" => "$cur",
				];

		}
		
		if($opt == "withcard"){ //  Card withdrawal
			
			$apiEndpoint = "https://api.blochq.io/v1/cards/withdraw/$cardID";
			
			$data = [
						"amount" => $amt,
						"to_account_id" => "$acctid",
						"currency" => "$cur",
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

?>