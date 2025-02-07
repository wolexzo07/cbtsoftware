<?php

	function x_getBA(){ // List all bill government agency

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/billers";
		
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

	function x_getAgencyProducts($billcode){ // Get all agency products by bill code

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/billers/$billcode/products";
		
		$queryParams = [ // parameter is optional 
				"biller_code" => "$billcode",
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


	function x_getAgencyAmt($billcode , $productcode){ // Get products amount by bill code and product code

		$secretKey = x_getFlwKey("live" , "s");	 
		
		$apiEndpoint = "https://api.flutterwave.com/v3/billers/$billcode/products/$productcode";

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
	
	
	function x_createRem($billcode , $productcode , $customer , $fields){ // create order details
		
		$apiEndpoint = "https://api.flutterwave.com/v3/billers/$billcode/products/$productcode/orders";
		
		$secretKey = x_getFlwKey("live" , "s");	
		
		$authorizationToken = "$secretKey";
		
		$cust = explode("==",$customer);
		
		if(count($cust) == "2"){
			$name = $cust[0];
			$email = $cust[1];
			$mobile = $cust[2];
		}else{
			echo "Customer details not valid (name==email==mobile)";
			exit();
		}
		
		$customer = [
			"name" => "$name",
			"email" => "$email",
			"phone_number" => "$mobile"
		];
		
		$field = explode("==",$fields);
		
		if(count($field) == "2"){
			$orderid = $field[0];
			$quantity = $field[1];
			$amount = $field[2];
		}else{
			echo "Fields details not valid (orderid==quantity==amount)";
			exit();
		}

		$fields = [
			"id" => "$orderid",
			"quantity" => "$quantity", // usually 1
			"value" => "$amount"
		];

		$data = [
			"customer" => $customer,
			"fields" => $fields,
			"country" => "NG", // optional start here
			"amount" => "$amount",
			"reference" => "$ref" // unique reference by developer
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
	
	
	function x_updateBillOrder($order_id , $amount){ // update Bill order id
	
		$apiEndpoint = "https://api.flutterwave.com/v3/product-orders/$order_id";
		
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
		  // amount is the one you want to update it with | reference is optional
		  CURLOPT_POSTFIELDS =>"{
			'amount': '$amount',
			'reference': '$ref' 
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


	// Extra Remitta functions

	function x_extractRData($json){ // extracting the data
		
		$dataArray = json_decode($json, true);
		
		$extractedData = [];

		if ($dataArray && isset($dataArray['data'])) {
			
			$extractedData = array_map(function($item) {
				
				return [
					'code' => $item['code'],
					'name' => $item['name'],
				];
				
			}, $dataArray['data']);
			
		}

		return $extractedData;
		
	}
	
	function x_getRemBillers(){
		$response = x_getBA();
		$data = json_decode($response,true);
		
		include("validateArray.php");
		
		if($data["status"] == "success"){
			
			$extracted = x_extractRData($response);

						?>
		<select name="gov-list" id="govlist" onchange="getGovAmount(this.value)" class="form-select">
			<?php
				$outdated = ["FEDERAL MINISTRY OF AVIATION","FEDERAL MINISTRY OF EDUCATION","ADULT & NON-FORMAL EDUCATION BOARD - KOGI STATE GOVERNMENT"];
				
				foreach($extracted as $entry){
					$billname = $entry["name"];
					$billcode = $entry["code"];
					
					$linker = $billname."---".$billcode;
					
					if(in_array($billname , $outdated)){
						
					}else{
					?>
					<option value="<?php echo $linker;?>"><?php echo strtoupper($billname);?> </option>
					<?php
					}
				}
			?>
		</select>
		
		<script>
			var str = $("#govlist").val();
			contentByExtraid(str,".get-product","fetch-gov-product","timothy");
		</script>

		<?php
		}

	}
	
	function x_extractRPData($json){ // extracting the data remitta product
		
		$dataArray = json_decode($json, true);
		
		$extractedData = [];

		if ($dataArray && isset($dataArray['data']['products'])) {
			
			$extractedData = array_map(function($item) {
				
				return [
					'code' => $item['code'],
					'name' => $item['name'],
					'amount' => $item['amount'],
					'fee' => $item['fee'],
					'description' => $item['description'],
				];
				
			}, $dataArray['data']['products']);
			
		}

		return $extractedData;
		
	}
	
	
	function x_getRemBilProduct($billcode){ // fetching all governmental product lists
		
		$response = x_getAgencyProducts($billcode);
		$data = json_decode($response,true);
		
		include("validateArray.php");
		
		if($data["status"] == "success"){
		
		$extracted = x_extractRPData($response);
		
			?>
		<select name="gov-list-product" id="glistproduct" onchange="getproductAmount(this.value)" class="form-select">
			<?php
				foreach($extracted as $entry){
					$billname = $entry["name"];
					$productcode = $entry["code"];
					$billdes = $entry["description"];
					$billamount = $entry["amount"];
					$billfee = $entry["fee"];
					
					$linker = $billname."---".$billcode."---".$productcode;
					?>
					<option value="<?php echo $linker;?>"><?php echo strtoupper($billname);?> </option>
					<?php
				}
			?>
		</select>
		
		<script>
			var str = $("#glistproduct").val();
			contentByExtraid(str,".get-product-amount","gov-product-amount","timothy");
		</script>
		<?php
		
		}else{
			
			?>
		<script>
			$("#amount_id").hide();
		</script>
			<?php
			
		}
			
	}
?>