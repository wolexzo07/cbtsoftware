<?php

	function x_payBlocBills($option , $pid , $opid , $accid , $meter_type , $devnumb , $msisdn , $amt){ // Make payment for bills
	
		$secretKey = x_getBlocKey("live" , "s");	
		
		$authorizationToken = "$secretKey";

		$allowed = ["telco","elect","tele"];
		
		if(!in_array($option , $allowed)){
			print("Option <b>$option</b> not allowed!!");
			exit();
		}
		
		if($option == "telco"){ // airtime
			
			$apiEndpoint = 'https://api.blochq.io/v1/bills/payment?bill=telco';
			
			$deviceDetails = [
			"beneficiary_msisdn" => "$msisdn",
			];
			
		}

		if($option == "elect"){ // electricity
			
			$apiEndpoint = 'https://api.blochq.io/v1/bills/payment?bill=electricity';
			
			$deviceDetails = [
			"meter_type" => "$meter_type",
			"device_number" => "$devnumb", 
			];
			
		}
		
		if($option == "tele"){ // cable
		
			$apiEndpoint = 'https://api.blochq.io/v1/bills/payment?bill=television';
			
			$deviceDetails = [
			"device_number" => "$devnumb",
			];
			
		}
		
		$amt = $amt * 100;
		
		$data = [
			"amount" => $amt,
			"product_id" => "$pid", 
			"operator_id" => "$opid",
			"account_id" => "$accid",
			"device_details" => $deviceDetails,
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
	

	function x_BlocValidator($category , $operatorID , $meterType , $deviceNumber){ // Validator
	
		$secretKey = x_getBlocKey("live" , "s");	
		
		$apiEndpoint = "https://api.blochq.io/v1/bills/customer/validate/$operatorID";
		
		// Bloc category listings start here
		
		if($category == "t"){ // television
			
			$queryParams = [
				"bill" => "television",
				"device_number" => "$deviceNumber", // smart card number
			];
			
		}

		if($category == "e"){ // power
			
			$queryParams = [
				"bill" => "electricity",
				"meter_type" => "$meterType",
				"device_number" => "$deviceNumber", // meter number
			];
			
		}

		$queryString = http_build_query($queryParams);
		$ch = curl_init($apiEndpoint . '?' . $queryString);

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
	

	function x_getBlocOperatorList($category , $operatorID){ // Getting Bills operators product list
	
		$secretKey = x_getBlocKey("live" , "s");	
		
		$apiEndpoint = "https://api.blochq.io/v1/bills/operators/$operatorID/products";
		
		// Bloc category listings start here
		
		if($category == "telco-a"){ // airtime
			
			$queryParams = [
				"bill" => "telco",
				//"CategoryID" => "pctg_xkf8nz3rFLjbooWzppWBG6",
			];
			
		}

		if($category == "telco-d"){ //data
			
			$queryParams = [
				"bill" => "telco",
				//"CategoryID" => "pctg_ftZLPijqrVsTan5Ag7khQx",
			];
			
		}	
		
		if($category == "electricity"){ // electricity
			
			$queryParams = [
				"bill" => "electricity",
			];
			
		}	
		
		if($category == "television"){ // Cable
			
			$queryParams = [
				"bill" => "television",
			];
			
		}	


		$queryString = http_build_query($queryParams);
		$ch = curl_init($apiEndpoint . '?' . $queryString);

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
	
	function x_getBlocCategories($category){ // Getting Bills operators	
	
		$secretKey = x_getBlocKey("live" , "s");	
		
		$apiEndpoint = "https://api.blochq.io/v1/bills/operators";
		
		// Bloc category listings start here
		
		if($category == "telco"){ // airtime & data
			
			$queryParams = [
				"bill" => "telco",
			];
			
		}	
		
		if($category == "electricity"){ // electricity
			
			$queryParams = [
				"bill" => "electricity",
			];
			
		}	
		
		if($category == "television"){ // Cable
			
			$queryParams = [
				"bill" => "television",
			];
			
		}	


		$queryString = http_build_query($queryParams);
		$ch = curl_init($apiEndpoint . '?' . $queryString);

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