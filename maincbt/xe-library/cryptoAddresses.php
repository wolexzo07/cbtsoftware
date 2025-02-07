<?php

function x_validateAllCrAddr($currency, $address){
	
	if($currency == "btc"  || $currency == "tbtc"){
	
		$response = x_validateBitcoinAddress($address);

	}elseif($currency == "usdt@trx"){
	
		$response = x_validateTetherAddress($address);

	}elseif($currency == "doge"){
	
		$response = x_validateDogecoinAddress($address);

	}elseif($currency == "ltc"){
	
		$response = x_validateLitecoinAddress($address);

	}elseif($currency == "bch"){
	
		$response = x_validateBitcoinCashAddress($address);

	}elseif($currency == "trx"){
	
		$response = x_validateTronAddress($address);

	}else{
		
		$response = "Nothing";
		
	}
	
	return $response;
	
}


function x_validateBitcoinAddress($address) {
	
	$regex = "/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/";
		
	$regexOne = "/^\b((bc|tb)(0([ac-hj-np-z02-9]{39}|[ac-hj-np-z02-9]{59})|1[ac-hj-np-z02-9]{8,87})|([13]|[mn2])[a-km-zA-HJ-NP-Z1-9]{25,39})\b$/"; // Bech32 | legacy | Testnet

	if(preg_match($regex , $address) || preg_match($regexOne , $address)){
		
		$response = "valid";
		
	}else{
		
		$response = "invalid";
		
	}
	
	return $response;
	
}


function x_validateTetherAddress($address) {

    if (preg_match('/^1[1-9A-HJ-NP-Za-km-z]{24,34}$/', $address)  || preg_match('/^(T|41)[0-9A-Za-z]{33}$/', $address)) {
        
		$response = "valid";
			
		}else{
			
			$response = "invalid";
			
		}
		
		return $response;
}

function x_validateDogecoinAddress($address) {

    if (preg_match('/^D{1}[5-9A-HJ-NP-U]{1}[1-9A-HJ-NP-Za-km-z]{32}$/', $address)) {
		
        $response = "valid";
			
	}else{
		
		$response = "invalid";
		
	}
		
		return $response;
}

function x_validateLitecoinAddress($address) {
	
    if (preg_match('/^[LM3][a-km-zA-HJ-NP-Z1-9]{26,33}$/', $address)) {
		
       $response = "valid";
			
	}else{
		
		$response = "invalid";
		
	}
		
		return $response;
}

function x_validateBitcoinCashAddress($address) {

    if (preg_match('/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/', $address)) {
		
       $response = "valid";
			
	}else{
		
		$response = "invalid";
		
	}
		
		return $response;
}

function x_validateTronAddress($address) {

    if (preg_match('/^[T][1-9A-Za-z]{33}$/', $address)) {
		
        $response = "valid";
			
	}else{
		
		$response = "invalid";
		
	}
		
		return $response;
}


?>
