<?php
/**************FETCHING VIRTUAL CARDS***********************/

function x_createVirtualCard($cardcurrency , $prefundAmt , $debitCurrency , $firstname , $lastname , $dob ,$email , $mobile , $title , $gender , $callback_url){ // create new card
	
	$apiEndpoint = "https://api.flutterwave.com/v3/virtual-cards";
	
	$secretKey = x_getFlwKey("live" , "s");	
	
	$authorizationToken = "$secretKey";

	$data = [
	"currency" => "$cardcurrency", // NGN | USD
    "amount" => $prefundAmt, 
    "debit_currency" => "$debitCurrency", // DEBIT FROM NGN | USD FLW WALLET
	"first_name" => "$firstname",
    "last_name" => "$lastname",
    "date_of_birth" => "$dob",
    "email" => "$email",
    "phone" => "$mobile",
    "title" => "$title", // Mr, Mrs and Miss
    "gender" => "M", // F | M
    "callback_url" => "$callback_url",
    "billing_name" => "",
    "billing_address" => "",
    "billing_city" => "",
    "billing_state" => "",
    "billing_postal_code" => "",
    "billing_country" => "",
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


function x_getAllVirtualCard(){ // fetch all virtual cards created
	
	$secretKey = x_getFlwKey("live" , "s");
	
	$apiEndpoint = "https://api.flutterwave.com/v3/virtual-cards";

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

function x_getVirtualCardById($cardID){ // Fetch card details by ID
	
	$secretKey = x_getFlwKey("live" , "s");
	
	$apiEndpoint = "https://api.flutterwave.com/v3/virtual-cards/$cardID";

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


function x_fundVirtualCard($cardID , $debitcurrency , $amount){ // Fund card by ID
	
	$apiEndpoint = "https://api.flutterwave.com/v3/virtual-cards/$cardID/fund";
	
	$secretKey = x_getFlwKey("live" , "s");	
	
	$authorizationToken = "$secretKey";

	$data = [
		"debit_currency" => "$debitcurrency", // NGN | USD
		"amount" => $amount, // Amount in card currency
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


function x_withVirtualCard($cardID , $debitcurrency , $amount){ // withdraw from card
	
	$apiEndpoint = "https://api.flutterwave.com/v3/virtual-cards/$cardID/withdraw";
	
	$secretKey = x_getFlwKey("live" , "s");	
	
	$authorizationToken = "$secretKey";

	$data = [
		"amount" => $amount, // Amount to be withdrawn back to user USD wallet
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

function x_blockUnblockVC($cardID , $status){ // status = block | unblock 
	
	$apiEndpoint = "https://api.flutterwave.com/v3/virtual-cards/$cardID/status/$status";
	
	$secretKey = x_getFlwKey("live" , "s");	
	
	$authorizationToken = "$secretKey";
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "$apiEndpoint",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "PUT",
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


function x_terminateCard($cardID){ // Terminate a card
	
	$apiEndpoint = "https://api.flutterwave.com/v3/virtual-cards/$cardID/terminate";
	
	$secretKey = x_getFlwKey("live" , "s");	
	
	$authorizationToken = "$secretKey";
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "$apiEndpoint",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "PUT",
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

function x_getCardTranx($cardID , $from , $to , $index , $size){ // get a card transaction
	
	$secretKey = x_getFlwKey("live" , "s");	
	
	$apiEndpoint = "https://api.flutterwave.com/v3/virtual-cards/$cardID/transactions";
	
	$queryParams = [
			"from" => "$from", // YYYY/MM/DD
			"to" => "$to", // YYYY/MM/DD
			"index" => $index, // 1 or 0 (start from beginning)
			"size" => $size, // No. of tranx to get in a call
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