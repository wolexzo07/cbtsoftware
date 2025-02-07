<?php
	
	function x_getPoweroptions($switch){
		
			$category = "e";
			$response = x_getBillCategories($category);
			$extracted = x_extractData($response);
			
			include("validateArray.php");
		
		?>
		<select name="provider" id="curVal" onchange="cableHidden(this.value , '.hidden-power' ,'p')" class="form-select">
			<?php
				foreach($extracted as $entry){
					$billname = $entry["biller_name"];
					$name = $entry["name"];
					$billcode = $entry["biller_code"];
					$itemcode = $entry["item_code"];
					$shortname = $entry["short_name"];
					
					$linker = $billname."---".$billcode."---".$itemcode;
					
					if($shortname == "Kaduna Prepaid"){
						$billname = "KADUNA DISCO PREPAID";
					}
					
					if($shortname == "Kaduna Postpaid"){
						$billname = "KADUNA DISCO POSTPAID";
					}
					
					$prepaid = substr_count(strtoupper($billname),strtoupper("PREPAID"));
					$postpaid = substr_count(strtoupper($billname),strtoupper("POSTPAID"));
					
					if($switch == "prepaid"){
						if($prepaid > 0){
							?>
							<option value="<?php echo $linker;?>"><?php echo strtoupper($billname);?> </option>
							<?php
						}
					}
					
					if($switch == "postpaid"){
						if($postpaid > 0){
							?>
							<option value="<?php echo $linker;?>"><?php echo strtoupper($billname);?> </option>
							<?php
						}
					}
					
					
				}
			?>
		</select>
		<?php
		
	}
	
	function x_getBillers($category){
		
		$response = x_getBillCategories($category);
	
		$extracted = x_extractData($response);
		
		include("validateArray.php");
		
		$cablelist = ["dstv","gotv","star"];
		$internetlist = ["sm","ip"];
		$internetlist_no = ["swift","mtn-hynet"];
		
		if(in_array($category , $cablelist)){
			?>
			<select name="datatype" id="curVal" onchange="cableHidden(this.value , '.hidden-plans' , 'c')" class="form-select">
				<?php
					foreach($extracted as $entry){
						$billname = $entry["biller_name"];
						$billcode = $entry["biller_code"];
						$itemcode = $entry["item_code"];
						$amount = $entry["amount"];
						
						$linker = $billname."---".$billcode."---".$itemcode."---".$amount;
						?>
						<option value="<?php echo $linker;?>">NGN <?php echo number_format($amount,2);?> ==> <?php echo $billname;?> </option>
						<?php
					}
				?>
			</select>
			<?php
		}elseif(in_array($category , $internetlist)){
			?>
			<select name="datatype" id="curVal" onchange="cableHidden(this.value , '.hidden-plans' , 'c')" class="form-select">
				<?php
					foreach($extracted as $entry){
						$billname = $entry["biller_name"];
						$billcode = $entry["biller_code"];
						$itemcode = $entry["item_code"];
						$amount = $entry["amount"];
						
						$linker = $billname."---".$billcode."---".$itemcode."---".$amount;
						?>
						<option value="<?php echo $linker;?>">NGN <?php echo number_format($amount,2);?> ==> <?php echo $billname;?> </option>
						<?php
					}
				?>
			</select>
	
			<div class="mt-4">
				<input type="text" placeholder="Account number" name="account_number" class="form-control" required=""/>
			</div>
				
			<?php
		}elseif(in_array($category , $internetlist_no)){
			
			$data = json_decode($response,true);
			
			include("validateArray.php");
			
			//print_r($data);
			
			if($data["status"] == "success"){
				
				$label = $data["data"][0]["label_name"];
				$amount = $data["data"][0]["amount"];
				$billname = $data["data"][0]["biller_name"];
				$billcode = $data["data"][0]["biller_code"];
				$itemcode = $data["data"][0]["item_code"];
				
				?>
				<div class="">
					<input type="text" placeholder="<?php echo $label;?>" name="account_number" class="form-control" required=""/>
				</div>
				
				<div class="mt-4">
					<input type="number" placeholder="Enter amount" name="amount" class="form-control" required=""/>
				</div>
				
				<?php
			}
			
			?>
			<?php
		}else{
			?>
			<select name="datatype" class="form-select">
			<?php
				foreach($extracted as $entry){
					$billname = $entry["biller_name"];
					$billcode = $entry["biller_code"];
					$itemcode = $entry["item_code"];
					$amount = $entry["amount"];
					
					$linker = $billname."---".$billcode."---".$itemcode."---".$amount;
					?>
					<option value="<?php echo $linker;?>">NGN <?php echo number_format($amount,2);?> ==> <?php echo $billname;?> </option>
					<?php
				}
			?>
			</select>
		<?php
		}

	}
	
	
	
	function x_extractData($json){
		
		$dataArray = json_decode($json, true);
		
		$extractedData = [];

		if ($dataArray && isset($dataArray['data'])) {
			
			$extractedData = array_map(function($item) {
				
				return [
					'biller_name' => $item['biller_name'],
					'item_code' => $item['item_code'],
					'biller_code' => $item['biller_code'],
					'amount' => $item['amount'],
					'default_commission' => $item['default_commission'],
					'name' => $item['name'],
					'short_name' => $item['short_name'],
				];
				
			}, $dataArray['data']);
			
		}

		return $extractedData;
		
	}
	

	function x_flwreadJsonData($jsonResponse , $sectionToRead , $columnToRead){
		
		$dataArray = json_decode($json, true);
		
		if($dataArray["status"] != "success"){
			
			$response = "failed";
			
		}else{
		
			if ($dataArray && isset($dataArray[$sectionToRead])) {

				$billerNames = array_column($dataArray[$sectionToRead], $columnToRead);

				foreach ($billerNames as $billerName) {
					
					$response[] = $billerName;
					
				}
				
			} else {
				
				$response = "invalidJson";
				
			}
			
		}
		
		return $response;
		
	}

// Flutterwave Billpayments integrations

function x_genBillsRecord($from , $to , $customerID , $page){ 
	
	$secretKey = x_getFlwKey("live" , "s");	//validating : smart card no. | meter no.
	
	$apiEndpoint = "https://api.flutterwave.com/v3/bills";
	
	$queryParams = [
			"from" => "$from", // From date YYYY-MM-DDTHH:MM:SSZ or YYYY-MM-DD
			"to" => "$to", // To date YYYY-MM-DDTHH:MM:SSZ or YYYY-MM-DD
			"reference" => "$customerID", // customer ID (optional)
			"page" => "$page", // Page to start from  (optional)
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


function x_getBillStatus($tx_ref){ // get bills status | pending | success | error
	
	$secretKey = x_getFlwKey("live" , "s");	
	
	$apiEndpoint = "https://api.flutterwave.com/v3/bills/$tx_ref";
	
	$queryParams = [
			"verbose" => 1, // return status from provider
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


function x_billValidator($item_code , $biller_code , $customerid){ 
	
	$secretKey = x_getFlwKey("live" , "s");	//validating : smart card no. | meter no.
	
	$apiEndpoint = "https://api.flutterwave.com/v3/bill-items/$item_code/validate";
	
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

function x_payBills($currency , $type , $customerid , $amount , $reference){
	
	$apiEndpoint = 'https://api.flutterwave.com/v3/bills';
	
	$secretKey = x_getFlwKey("live" , "s");	
	
	$authorizationToken = "$secretKey";

	$data = [
		"country" => "$currency",
		"customer" => "$customerid", // mobil for airtime_data | smart card no. | meter no.
		"amount" => $amount,
		"type" => "$type",
		"reference" => "$reference",
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


function x_getBillCategories($category){	
	
	$secretKey = x_getFlwKey("live" , "s");	
	
	$apiEndpoint = "https://api.flutterwave.com/v3/bill-categories";
	
	// Filtering Telecom Airtime for all network

	if($category == "airtime"){ // airtime = All network top-up
		
		$queryParams = [
			"airtime" => "1",
			"biller_code" => "BIL099",
		];
		
	}	

	// Filtering Telecom Data Bundles
	
	if($category == "all_data"){ // mtn-d = MTN Data Bundle listing
		
		$queryParams = [
			"internet" => "1",
			"country" => "NG",
		];
		
	}
	
	if($category == "mtn-d"){ // mtn-d = MTN Data Bundle listing
		
		$queryParams = [
			"data_bundle" => "1",
			"biller_code" => "BIL108",
		];
		
	}
	
	if($category == "glo-d"){ // glo-d = GLO Data Bundle listing
		
		$queryParams = [
			"data_bundle" => "1",
			"biller_code" => "BIL109",
		];
		
	}

	if($category == "air-d"){ // air-d = AIRTEL Data Bundle listing
		
		$queryParams = [
			"data_bundle" => "1",
			"biller_code" => "BIL110",
		];
		
	}

	if($category == "9mob-d"){ // 9mob-d = 9MOBILE Data Bundle listing
		
		$queryParams = [
			"data_bundle" => "1",
			"biller_code" => "BIL111",
		];
		
	}	
	
	// Filtering Electricity Power
	
	if($category == "e"){ // e = Electriciy power
		
		$queryParams = [ 
			"power" => "1",
			"country" => "NG",
		];
		
	}
	
	// Filtering Cable companies
	
	if($category == "dstv"){ // dstv = DSTV TOPUP
		
		$queryParams = [ 
			"cables" => "1",
			"biller_code" => "BIL121",
		];
		
	}

	if($category == "gotv"){ // gotv = GOTV TOPUP
		
		$queryParams = [ 
			"cables" => "1",
			"biller_code" => "BIL122",
		];
		
	}	
	
	if($category == "star"){ // star = startimes decoder
		
		$queryParams = [
			"cables" => "1",
			"biller_code" => "BIL123",
		];
		
	}	
	
	
	// Filtering Internet companies
	
	if($category == "sm"){ // smile = Smile internet subscription
		
		$queryParams = [ 
			"internet" => "1",
			"biller_code" => "BIL124",
		];
		
	}

	if($category == "ip"){ // ip = ipNX internet subscription
		
		$queryParams = [ 
			"internet" => "1",
			"biller_code" => "BIL129",
		];
		
	}

	if($category == "swift"){ // swift = Swift 4G internet subscription
		
		$queryParams = [ 
			"internet" => "1",
			"biller_code" => "BIL126",
		];
		
	}

	if($category == "mtn-hynet"){ // Hynet = Mtn Hynet internet subscription
		
		$queryParams = [ 
			"internet" => "1",
			"biller_code" => "BIL136",
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


function x_getFlwKey($liveortest , $switch){
	
	$allowed = ["live","test"];
	$allowedswitch = ["p","s","e"]; // secret | public | encryption
	
	if(in_array($liveortest,$allowed) && in_array($switch,$allowedswitch)){
		
		if($switch == "s"){
			
			$type = "secretkey";
			
		}elseif($switch == "p"){
			
			$type = "publickey";
			
		}else{
			
			$type = "encryptionkey";
			
		}
		
		$getKey = x_getsingleupdate("paymentkeys","$type","company='flutters' AND statustype='$liveortest'");
		
		$response = $getKey;
	}
	
	return $response;
	
}

?>