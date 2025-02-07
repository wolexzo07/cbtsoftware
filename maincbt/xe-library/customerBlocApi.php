<?php

 	function x_createBlocCustomers($email,$mobile,$first,$last,$ctype,$bvn){ // Create Bloccustomers

			$apiEndpoint = "https://api.blochq.io/v1/customers";
			
			$secretKey = x_getBlocKey("live" , "s");	
			
			$authorizationToken = "$secretKey";
			
			$data = [
					"email" => "$email",
					"phone_number" => "$mobile", 
					"first_name" => "$first", 
					"last_name" => "$last", 
					"customer_type" => "$ctype", 
					"bvn" => "$bvn", 
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
	

	function x_blocKYC($custID,$kyctype,$pob,$dob,$gen,$street,$city,$state,$country,$poscode,$image,$mofid,$mofid_image,$docnumb){ // Handle KYC 1-2-2v2-3

		$allowed = [1,2,'2v2',3];
		
		if(!in_array($kyctype , $allowed)){
			
			return "kyc option is invalid";
			
			exit();
			
		}
		
		if($kyctype == "1"){
			
			$apiEndpoint = "https://api.blochq.io/v1/customers/upgrade/t1/$custID";
			
			$address = [
					"street" => "$street",
					"city" => "$city", 
					"state" => "$state", 
					"country" => "$country", 
					"postal_code" => "$poscode", 
				];
			
			$data = [
					"place_of_birth" => "$pob",
					"dob" => "$dob",
					"gender" => "$gen",
					"country" => "$country",
					"address" => $address,
					"image" => "$image", // base64/image
				];
		}
		
		if($kyctype == "2"){
			
			$apiEndpoint = "https://api.blochq.io/v1/customers/upgrade/t2/$custID";
			
			$data = [
					"means_of_id" => "$mofid",
					"image" => "$mofid_image", // base64/image
				];
		}
		
		if($kyctype == "2v2"){
			
			$apiEndpoint = "https://api.blochq.io/v1/customers/upgrade/t2/v2/$custID";
			
			$data = [
					"means_of_id" => "$mofid",
					"image" => "$mofid_image", // base64/image
					"document_number" => "$docnumb", // document number
				];
		}
		
		if($kyctype == "3"){
			
			$apiEndpoint = "https://api.blochq.io/v1/customers/upgrade/t3/$custID";
			
			$data = [
					"image" => "$image", // base64/image
				];
			
		}
		
		$jsonData = json_encode($data);
		
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
		  CURLOPT_POSTFIELDS => $jsonData,
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
	
	// update customer details
	
	function x_updateBlocCust($customerID,$email,$mobile,$ctype,$bvn,$street,$city,$state,$country,$poscode){ 
	
		$apiEndpoint = "https://api.blochq.io/v1/customers/$customerID";
		
		$address = [
					"street" => "$street",
					"city" => "$city", 
					"state" => "$state", 
					"country" => "$country", 
					"postal_code" => "$poscode", 
				];
				
		$data = [
					"email" => "$email",
					"phone_number" => "$mobile", 
					"customer_type" => "$ctype", 
					"bvn" => "$bvn", 
					"address" => $address, 
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
	
	
	
	function x_getBlocCustomers(){ // Get bloc Customers
	
		$secretKey = x_getBlocKey("live" , "s");	
		
		$apiEndpoint = "https://api.blochq.io/v1/customers";
		
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
	
	
	function x_getBlocCustomByID($customerID){ // Get bloc Customers by ID
	
		$secretKey = x_getBlocKey("live" , "s");	
		
		$apiEndpoint = " https://api.blochq.io/v1/customers/$customerID";
		
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


	function x_BlocMofID(){ // Get Means of Identification
	
		$secretKey = x_getBlocKey("live" , "s");	
		
		$apiEndpoint = "https://api.blochq.io/v1/customers/means/identity";
		
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
	
	function x_RevalidateBlocKYC($customerID){ // Get bloc Customers by ID
	
		$secretKey = x_getBlocKey("live" , "s");	
		
		$apiEndpoint = "https://api.blochq.io/v1/customers/kyc/revalidate/$customerID";
	
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