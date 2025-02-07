<?php
	
	include_once("cryptofunctions.php");
	
	// Create crypto wallets
	
	function x_AprsetupWallet($currency, $uid , $utoken, $callbackurl , $is_forward , $destination_address , $n_fee , $pfp){ 
		
		$allowed = ["tbtc","btc","ltc","bch","doge","trx","usdt@trx"];
		
		if(!in_array($currency , $allowed)){
			
			$list = implode("---",$allowed);
			
			echo "Crypto not supported ($list)";
			
			exit();
		}
		
		$wtoken = wallettoken($utoken);
		
		$url = 'https://apirone.com/api/v2/wallets';
		
		$userData = [
					'uid' => "$uid",
					'utoken' => "$utoken",
					'wtoken' => "$wtoken",
					'currency' => "$currency"
		];
		
		$callback = [
				'method'  => "POST",
				'url'  => "$callbackurl",
				'data' => $userData
		];
		
		if($is_forward == "1"){
			
			$destination = [
					[
						'address' => "$destination_address",
						'amount' => '100%'
					]
				];
		}else{
			
			$destination = "";
			
		}

		$data = [
				'currency' => "$currency",
				'callback' => $callback,
				'destinations' => $destination,
				'fee' => "$n_fee", // network fee :: normal | priority
				'processing-fee-policy' => "$pfp" // fixed | percentage
		];

		$jsonData = json_encode($data);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);
		
		if ($response === false) { 
		
			//echo 'cURL error: ' . curl_error($ch);
			
		}
		
		curl_close($ch);
		
		return $response;
	}
	

	// Wallet Information
	
	function x_AprwalletInfo($wallet_id){ 
		
			if(!isset($wallet_id)){
				
				echo "Wallet Identifier is missing";
				
				exit();
			}
			
			$url = "https://apirone.com/api/v2/wallets/$wallet_id";
			
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
			
			return $response;
		
	}

	
	// Wallet balance
	
	function x_AprwalletBalance($wallet_id , $waddr , $is_addresses_true){ 
		
			if(!isset($wallet_id)){
				
				echo "Wallet Identifier is missing";
				
				exit();
			}
			
			$url = "https://apirone.com/api/v2/wallets/$wallet_id/balance";
			
			if($is_addresses_true == "yes"){ // optional for certain addresses
				
				$queryString = http_build_query(array(
				
					'addresses' => $waddr // can be separated by comma for multiple
					
				));
				
				$url .= '?' . $queryString;	
			}

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
			
			return $response;
	
	}
	
	
// Generate wallet addresses

	function x_AprgenerateAddr($currency, $wallet_id , $uid , $utoken , $callback){
	
		$url = "https://apirone.com/api/v2/wallets/$wallet_id/addresses";
		
		if($currency == "btc" || $currency == "tbtc"){
			
			$addr_type = "p2sh-p2wpkh";
			
		}elseif($currency == "trx" || $currency == "usdt@trx"){
			
			$addr_type = "generic";
			
		}else{
			
			$addr_type = "p2pkh";
			
		}
		
		$secret = sha1(str_shuffle(md5($uid."-".$utoken).uniqid()));
		
		$invno = str_shuffle(strtoupper((md5($uid."-".$utoken.uniqid()))));
		
		$wtoken = wallettoken($utoken);
		
		$more = [
					'currency' => "$currency",
					'uid' => "$uid",
					'utoken' => "$utoken",
					'wtoken' => "$wtoken",
					'invoice_id' => "$invno",
					'secret' => "$secret"
				];
				
		$cb  = [
				"method" => "POST",
				"url" => "$callback",
				"data" => $more
			   ];
		
		$data = [
			"addr-type" => "$addr_type",
			"callback" => $cb
		];

	
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json'
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		$response = curl_exec($ch);

		if ($response === false){
			
			$error = curl_error($ch);
			
			$result = "cURL Error: " . $error;
			
		}else{
			
			$result = $response;
			
		}
		
		curl_close($ch);
		
		return $result;
		
	}


	// Get wallet address info

	function x_Apraddressinfo($wallet_id , $waddr){
		
			if(!isset($wallet_id)){
				
				echo "Wallet Identifier is missing";
				
				exit();
			}
			
			$url = "https://apirone.com/api/v2/wallets/$wallet_id/addresses/$waddr";

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
			
			return $response;
		
	}
	
	// Get wallet address balance

	function x_ApraddressBalance($wallet_id , $waddr){
		
			if(!isset($wallet_id)){
				
				echo "Wallet Identifier is missing";
				
				exit();
			}
			
			$url = "https://apirone.com/api/v2/wallets/$wallet_id/addresses/$waddr/balance";

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
			
			return $response;
		
	}
	
	
	// List all wallet addresses
	
	function x_AprListWalletAddress($wallet_id , $limit , $offset){ 
		
			if(!isset($wallet_id)){
				
				echo "Wallet Identifier is missing";
				
				exit();
			}
			
			$url = "https://apirone.com/api/v2/wallets/$wallet_id/addresses";
			
			$queryString = http_build_query(array(
				'limit' => $limit, // 10
				'offset' => $offset // 0
				//'q' => "address:$waddr,empty:true"	
			));
			
			$url .= '?' . $queryString;	
			

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
			
			return $response;
	
	}
	
	
	// Estimates a transaction before sending in advance. 
	
	function x_AprEstimateTranx($wallet_id , $subtract_fee , $destination_addr, $amount_in_minor_orpercent , $n_fee , $from_addr , $sh_addr , $sh_amt , $is_admin){ 
		
			if(!isset($wallet_id)){
				
				echo "Wallet Identifier is missing";
				
				exit();
			}
			
			$list = [0,1];
			
			if(!in_array($is_admin , $list)){
				
				echo "Invalid option for admin";
				
				exit();
			}
			
			$url = "https://apirone.com/api/v2/wallets/$wallet_id/transfer";
			
			/**if($subtract_fee == "yes"){
				
				$ans = true;
				
			}else{
				
				$ans = false;
				
			}***/
			
			
			if($from_addr == ""){
				
				if($is_admin == "1"){
					
					$queryString = http_build_query(array(
					'destinations' => $destination_addr.":".$amount_in_minor_orpercent, 
					'fee' => "$n_fee", 
					'subtract-fee-from-amount' => "$subtract_fee",	
					));
					
				}else{
					
					$queryString = http_build_query(array(
					'destinations' => $destination_addr.":".$amount_in_minor_orpercent.",".$sh_addr.":".$sh_amt, 
					'fee' => "$n_fee", 
					'subtract-fee-from-amount' => "$subtract_fee",	
					));
					
				} 
				
			}else{
				
				if($is_admin == "1"){
					
					$queryString = http_build_query(array(
					'destinations' => $destination_addr.":".$amount_in_minor_orpercent,
					'fee' => "$n_fee", 
					'subtract-fee-from-amount' => "$subtract_fee",	
					'addresses' => "$from_addr",	
					));
					
				}else{
					
					$queryString = http_build_query(array(
					'destinations' => $destination_addr.":".$amount_in_minor_orpercent.",".$sh_addr.":".$sh_amt,
					'fee' => "$n_fee", 
					'subtract-fee-from-amount' => "$subtract_fee",	
					'addresses' => "$from_addr",	
					));
					
				}
	
			}
			

			$url .= '?' . $queryString;	

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
			
			return $response;
	
	}
	
	
	// Transfer crypto bte week
	
	function x_AprTransferCrypt($wallet_id , $trkey , $subtract_fee , $destina_addr , $amount_in_minor , $from_addr , $n_fee , $c_address , $cshareamt_in_minor , $is_admin){
		
		if(!isset($wallet_id)){
			
			echo "Wallet Identifier is missing";
			
			exit();
		}
		
		$list = [0,1];
		
		if(!in_array($is_admin , $list)){
			
			echo "Invalid option for admin";
			
			exit();
		}
			
		$url = "https://apirone.com/api/v2/wallets/$wallet_id/transfer";
		
		
		if($is_admin == "1"){
			
			$des = [
				
				[
					"address" => "$destina_addr",
					"amount" => $amount_in_minor
				]
				
			];
			
		}else{
			
			$des = [
				
				[
					"address" => "$destina_addr",
					"amount" => $amount_in_minor
				],
				
				[
					"address" => "$c_address",
					"amount" => $cshareamt_in_minor
				]
				
			];
			
		}
		

		if($from_addr == ""){
			
			$data = [
				"transfer-key" => "$trkey",
				"destinations" => $des,
				"fee" => "$n_fee", // normal || priority || 
				"subtract-fee-from-amount" => "$subtract_fee", // true | false
				//"addresses" => "$from_addr",
			];
			
		}else{
			
			$data = [
				"transfer-key" => "$trkey",
				"destinations" => $des,
				"fee" => "$n_fee", // normal || priority || 
				"subtract-fee-from-amount" => "$subtract_fee", // true | false
				"addresses" => "$from_addr",
			];
			
		}
		
		

	
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/json'
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		$response = curl_exec($ch);

		if ($response === false){
			
			$error = curl_error($ch);
			
			$result = "cURL Error: " . $error;
			
		}else{
			
			$result = $response;
			
		}
		
		curl_close($ch);
		
		return $result;
		
	}
	
	
	// Wallet History
	
	function x_AprWalletHistory($wallet_id , $addr , $limit , $offset , $filter_addr , $date_from , $date_to , $item_type){ 
		
			if(!isset($wallet_id)){
				
				echo "Wallet Identifier is missing";
				
				exit();
			}
			
			$url = "https://apirone.com/api/v2/wallets/$wallet_id/history";
			
			//$url = "https://apirone.com/api/v2/wallets/$wallet_id/history?addresses=$addr&limit=$limit&offset=$offset&q=date-from:$date_from,date-to:$date_to,item-type:$item_type";
			
			/***$qdata = [
					"address" => "$filter_addr",
					"date-from" => "$date_from",
					"date-to" => "$date_to",
					"item-type" => "$item_type"
				];***/
			
			/***$q = "item-type:$item_type,address:$filter_addr,date-from:$date_from,date-to:$date_to";
		
			$queryString = http_build_query(array(
				'q' => $q, 
				'addresses' => "$addr", // optional
				'limit' => $limit,	
				'offset' => $offset,	
			));
			
			$url .= '?' . $queryString;	
			****/

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
			
			return $response;
	
	}
	
	
	// Wallet History Item
	
	function x_AprWalletHistoryItem($wallet_id , $HistoryItemID){ 
		
			if(!isset($wallet_id)){
				
				echo "Wallet Identifier is missing";
				
				exit();
			}
			
			$url = "https://apirone.com/api/v2/wallets/$wallet_id/history/$HistoryItemID";
			
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
			
			return $response;
	
	}
	
	
	// Address History (Outputs a list of operations of a specified wallet address)
	
	function x_AprAddressHistory($wallet_id , $addr , $limit , $offset){ 
		
			if(!isset($wallet_id)){
				
				echo "Wallet Identifier is missing";
				
				exit();
			}
			
			$url = "https://apirone.com/api/v2/wallets/$wallet_id /addresses/$addr/history";
		
			$queryString = http_build_query(array(
				'limit' => $limit,	
				'offset' => $offset	
			));
			
			$url .= '?' . $queryString;	
			

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
			
			return $response;
	
	}
	
	
	// Wallet Callback Info
	
	function x_AprWalletCBInfo($wallet_id , $transfer_key){ 
		
			if(!isset($wallet_id)){
				
				echo "Wallet Identifier is missing";
				
				exit();
			}
			
			$url = "https://apirone.com/api/v2/wallets/$wallet_id/callback";
		
			$queryString = http_build_query(array(
				'transfer-key' => "$transfer_key"	
			));
			
			$url .= '?' . $queryString;	
			

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
			
			return $response;
	
	}
	
	
	// Address Callback Info
	
	function x_AprAddressCBInfo($wallet_id , $transfer_key , $addr){ 
		
			if(!isset($wallet_id)){
				
				echo "Wallet Identifier is missing";
				
				exit();
			}
			
			$url = "https://apirone.com/api/v2/wallets/$wallet_id/addresses/$addr/callback";
		
			$queryString = http_build_query(array(
				'transfer-key' => "$transfer_key"	
			));
			
			$url .= '?' . $queryString;	
			

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
			
			return $response;
	
	}



	// Address Callback log
	
	function x_AprAddressCBLog($wallet_id , $transfer_key , $addr){ 
		
			if(!isset($wallet_id)){
				
				echo "Wallet Identifier is missing";
				
				exit();
			}
			
			$url = "https://apirone.com/api/v2/wallets/$wallet_id/addresses/$addr/callback-log";
		
			$queryString = http_build_query(array(
				'transfer-key' => "$transfer_key"	
			));
			
			$url .= '?' . $queryString;	
			

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
			
			return $response;
	
	}
	
	
	// Exchange Rate in different currencies
	
		function x_AprExchangeRate($currency){ 
		
			if(!isset($currency)){
				
				echo "Currency is missing";
				
				exit();
			}
			
			$url = "https://apirone.com/api/v2/ticker?currency=$currency";
		
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)) {
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
		
			return $response;
	
	}
	
	// adjusting settings
	
	function x_AprSettings($option , $wallet_id , $trkey , $fee ,$cburl , $data_in_arr , $waddr , $percent){

			$url = "https://apirone.com/api/v2/wallets/$wallet_id";
	
			$destination = [ // forwarding of incoming assets
								[
									"address" => "$waddr",
									"amount" => "$percent%"
								]
							];
				
			$cb = [
					"url" => "$cburl", // callback url
					"data" => $data_in_arr,
				];
			
			if($option == "fee-update"){ // processing-fee-policy update
				
				$data = [
						"transfer-key" => "$trkey", // transfer key
						"processing-fee-policy" => "$fee"
					];
				
			}elseif($option == "cb-update"){ // callback update
				
				$data = [
						"transfer-key" => "$trkey", // transfer key
						"callback" => $cb
					];
				
			}elseif($option == "fw-update"){ // forwarding wallet
				
				$data = [
						"transfer-key" => "$trkey", // transfer key
						"destinations" => $destination
					];
				
			}else{
				
				$data = [
						"transfer-key" => "$trkey", // transfer key
						"processing-fee-policy" => "$fee",
						"callback" => $cb,
						"destinations" => $destination
					];
				
			}
			
			

			$postData = json_encode($data);
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST => 'PATCH',
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
				),
				CURLOPT_POSTFIELDS => $postData
			));

			$response = curl_exec($curl);

			if ($response === false) {
				
				echo 'cURL Error: ' . curl_error($curl);
				
			} else {
				
				return $response;
			}

			curl_close($curl);
	}

?>