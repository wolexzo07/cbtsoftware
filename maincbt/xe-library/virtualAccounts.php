<?php

// Create virtual account 

function x_genVirtualAccounts($currency , $email , $bvn , $trxref , $mobile , $firstname , $lastname){
	
	$apiEndpoint = 'https://api.flutterwave.com/v3/virtual-account-numbers';
	
	$secretKey = x_getFlwKey("live" , "s");	
	
	$authorizationToken = "$secretKey";

	$data = [
		"currency" => "$currency",
		"email" => "$email",
		"is_permanent" => true,
		"bvn" => "$bvn",
		"tx_ref" => "$trxref",
		"phonenumber" => "$mobile",
		"firstname" => "$firstname",
		"lastname" => "$lastname",
		"narration" => "$lastname $firstname",
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


function x_fetchVirtualAccounts($orderRef){ // Fetch account after generation
	
	$secretKey = x_getFlwKey("live" , "s");
	
	$apiEndpoint = "https://api.flutterwave.com/v3/virtual-account-numbers/$orderRef";

	$ch = curl_init($apiEndpoint);
	$authorizationHeader = "Authorization: Bearer $secretKey";
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [$authorizationHeader]);

	$response = curl_exec($ch);

	if(curl_errno($ch)) {
		
		$apiresponse = 'cURL Error: ' . curl_error($ch);
		
	} else {

		$apiresponse = $response;
	}

	curl_close($ch);
	
	return $apiresponse;
}


function x_updateVirtualBVN($orderRef , $bvn){ // update bvn after virtual acct is generated
	
	$apiEndpoint = "https://api.flutterwave.com/v3/virtual-account-numbers/$orderRef";
	
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
		'bvn': '$bvn'
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

function x_delVirtualAccount($orderRef){ // Delete virtual account
	
	$apiEndpoint = "https://api.flutterwave.com/v3/virtual-account-numbers/$orderRef";
	
	$secretKey = x_getFlwKey("live" , "s");	
	
	$authorizationToken = "$secretKey";

	$data = [
		"status" => "inactive",
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

function x_verifyTrx($dataid){ // Transfer verification
	
	$secretKey = x_getFlwKey("live" , "s");
	
	$apiEndpoint = "https://api.flutterwave.com/v3/transactions/$dataid/verify";

	$ch = curl_init($apiEndpoint);
	$authorizationHeader = "Authorization: Bearer $secretKey";
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [$authorizationHeader]);

	$response = curl_exec($ch);

	if(curl_errno($ch)) {
		
		$apiresponse = 'cURL Error: ' . curl_error($ch);
		
	} else {

		$apiresponse = $response;
	}

	curl_close($ch);
	
	return $apiresponse;
}


function x_resendWH($dataid){ // Resend WebHooks after failing
	
	$apiEndpoint = "https://api.flutterwave.com/v3/transactions/$dataid/resend-hook";
	
	$secretKey = x_getFlwKey("live" , "s");	
	
	$authorizationToken = "$secretKey";

	$data = [
		"wait" => 1,
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