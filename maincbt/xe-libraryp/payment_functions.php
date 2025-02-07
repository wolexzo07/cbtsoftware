<?php

// flutters fees 
function x_fwfees($amount){
	if(x_justvalidate($amount) && is_numeric($amount) && ($amount > 0)){
		$rate = (1.42/100) * $amount;
		// capping rate at NGN 2000
		if($rate > 2000){
			return 2000;
		}else{
			return number_format($rate,2);
		}
	}else{
		echo "Invalid amount parsed";
	}
}
// paystack fee function
function x_pstkfees($amount){
	if(x_justvalidate($amount) && is_numeric($amount) && ($amount > 0)){
		if($amount < 2500){
			$rate = (1.5/100) * $amount;
		}else{
			$rate = ((1.5/100) * $amount) + 100;
		}
		// capping rate at NGN 2000
		if($rate > 2000){
			return 2000;
		}else{
			return number_format($rate,2);
		}
	}else{
		echo "Invalid amount parsed";
	}
}

// Creating paystack Recipient for Bank accounts

function x_createRecipient($skey,$acctname,$acctnumb,$bankcode,$description){
	
	if(x_justvalidate($skey) && x_justvalidate($acctname) && x_justvalidate($acctnumb) && x_justvalidate($bankcode) && x_justvalidate($description) && is_numeric($acctnumb) && (strlen($acctnumb) == "10")){
		
		$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.paystack.co/transferrecipient",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_CUSTOMREQUEST => "POST",
			   CURLOPT_POSTFIELDS => json_encode([
					   "type"=>"nuban",
					   "name"=>$acctname,
					   "description"=>$description,
					   "account_number"=>$acctnumb,
					   "bank_code"=>$bankcode,
					   "currency"=>"NGN"
				  ]),
			  CURLOPT_HTTPHEADER => [
				"authorization: Bearer $skey", 
				"content-type: application/json",
				"cache-control: no-cache"
			  ],
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			if($err)
			{
				return "Error : ". $err;
			 //die('Curl returned error: ' . $err);
			}
			else{
				$tranx = json_decode($response, true);
				$status = $tranx["status"];
				$r_code = $tranx["data"]["recipient_code"];
				$active_status = $tranx["data"]["active"]; // 1
				//print_r($tranx);
				return $tranx;
				}
		
	}else{
		return "No response";
	}
	
}

// Make automated transfer from dashboard to Nigerian Banks

function x_paytransfer($skey,$amount,$recipient_code,$ref){
	
	if(x_justvalidate($skey) && x_justvalidate($amount) && x_justvalidate($recipient_code) && x_justvalidate($ref) && is_numeric($amount)){
		
	$money = $amount*100;
	$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.paystack.co/transfer",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_CUSTOMREQUEST => "POST",
			   CURLOPT_POSTFIELDS => json_encode([
					   "source"=>"balance",
					   "reason"=>"Domingos Payments",
					   "amount"=>$money,
					   "recipient"=>$recipient_code,
					   "reference"=>$ref
				  ]),
			  CURLOPT_HTTPHEADER => [
				"authorization: Bearer $skey", 
				"content-type: application/json",
				"cache-control: no-cache"
			  ],
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			if($err)
			{
				return "Error : ". $err;
			 //die('Curl returned error: ' . $err);
			}
			else{
				$tranx = json_decode($response, true);
				//$status = $tranx["status"];
				//$tr_code = $tranx["data"]["transfer_code"];
				//$tr_ref = $tranx["data"]["reference"];
				//$tr_status = $tranx["data"]["status"];
				// print_r($tranx);
				return $tranx;
				
				}
	}else{
		return "No response";
	}
	
}

?>