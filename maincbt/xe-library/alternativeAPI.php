<?php
	// Get current crypto rate by asset id
	
	function x_AlternativeRate($currency_id){ // https://alternative.me/crypto/api/
		
			if(!isset($currency_id)){
				
				echo "Currency id is missing";
				
				exit();
			}
			
			// LTC = 2; BTC = 1; BCH = 1831; DOGE = 74; USDT = 825; TRON = 1958;ETH = 1027
			
			$url = "https://api.alternative.me/v2/ticker/$currency_id/";
		
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			
			if (curl_errno($ch)){
				
				//echo 'cURL error: ' . curl_error($ch);
				
			}
			
			curl_close($ch);
		
			return $response;
	
	}
	
	
	function x_crytoindollar($currency){
		
		$lists = ["tbtc","btc","trx","doge","ltc","bch","usdt@trx","eth"];
		
		if(!in_array($currency , $lists)){
			
			echo "Invalid currency <b>$currency</b>";
			
			exit;
			
		}
		
		if($currency == "tbtc"){
			
			$currency_id = 1;
			
		}
		
		if($currency == "btc"){
			
			$currency_id = 1;
			
		}
		
		if($currency == "ltc"){
			
			$currency_id = 2;
			
		}
		
		if($currency == "trx"){
			
			$currency_id = 1958;
			
		}
		
		if($currency == "bch"){
			
			$currency_id = 1831;
			
		}
		
		if($currency == "doge"){
			
			$currency_id = 74;
			
		}
		
		if($currency == "eth"){
			
			$currency_id = 1027;
			
		}
		
		if($currency == "usdt@trx" || $currency == "usdt"){
			
			$currency_id = 825;
			
		}
		// LTC = 2; BTC = 1; BCH = 1831; DOGE = 74; USDT = 825; TRON = 1958;
	
		$rate = x_AlternativeRate($currency_id);
		
			$decode = json_decode($rate , true);
			
			if(isset($decode["data"][$currency_id]["quotes"]["USD"]["price"])){
				
				$rate = $decode["data"][$currency_id]["quotes"]["USD"]["price"];
				
			}else{
				
				$rate = 0;
				
			}
			
			return $rate;
		
	}
?>