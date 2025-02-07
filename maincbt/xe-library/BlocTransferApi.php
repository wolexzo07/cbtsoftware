<?php
	function x_BlocTranferFrmFixed($amt,$bcode,$acnumb,$note,$acct_id,$ref){ // Tranfer from fixed account

			$apiEndpoint = "https://api.blochq.io/v1/transfers";
			
			$secretKey = x_getBlocKey("live" , "s");	
			
			$authorizationToken = "$secretKey";
			
			$data = [
					"amount" => $amt,
					"bank_code" => "$bcode", 
					"account_number" => "$acnumb", 
					"narration" => "$note", 
					"account_id" => "$acct_id", 
					"reference" => "$ref", 
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
	
	
	function x_getBlocTransferByRef($reference){ // Get bloc Transfer by reference
	
		$secretKey = x_getBlocKey("live" , "s");	
		
		$apiEndpoint = "https://api.blochq.io/v1/transactions/reference/$reference";

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
	
	
	function x_BlocTranferFrmOrgBal($amt,$bcode,$acnumb,$note,$ref){ // Tranfer from Organization account

			$apiEndpoint = "https://api.blochq.io/v1/transfers/balance";
			
			$secretKey = x_getBlocKey("live" , "s");	
			
			$authorizationToken = "$secretKey";
			
			$data = [
					"amount" => $amt,
					"bank_code" => "$bcode", 
					"account_number" => "$acnumb", 
					"narration" => "$note",  
					"reference" => "$ref", 
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
	
	
	function x_BlocInternalTranfer($amt,$from_acctid,$to_acctid,$note,$ref){ // Internal Transfer

			$apiEndpoint = "https://api.blochq.io/v1/transfers/internal";
			
			$secretKey = x_getBlocKey("live" , "s");	
			
			$authorizationToken = "$secretKey";
			
			$data = [
					"amount" => $amt,
					"from_account_id" => "$from_acctid", 
					"to_account_id" => "$to_acctid", 
					"narration" => "$note",  
					"reference" => "$ref", 
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
	
	
?>