<?php
	
	include("cryptoAddresses.php");
	include("alternativeAPI.php");
	
	// Get wallet_id and Trkey
	
	function x_FetchWidTrk($currency , $utoken){
		
		$wtoken = wallettoken($utoken);
		
		if(x_count("crypto_credentials","wtoken='$wtoken' AND utoken='$utoken' AND currency = '$currency'  LIMIT 1") > 0){
			
			foreach(x_select("wallet_id , transfer_key","crypto_credentials","wtoken='$wtoken' AND utoken='$utoken' AND currency = '$currency'","1","id") as $wallet){
				
				$wid = x_unmaskInputs($wallet["wallet_id"] , 20);
				$trk = x_unmaskInputs($wallet["transfer_key"] , 20);
				
			}
			
			$response = $wid."----".$trk;
			
		}else{
			
			$response = "failed";
			
		}
		
		return $response;
		
	}
	
	// Handle empty
	
	function x_chbpEmpty($input , $is_int){
		
		$input = @trim($input);
		
		if($input == ""){
			
			$response = "empty";
			
		}else{
			
			if($is_int == "1"){
					
				if(is_numeric($input)){
					
					$response = $input;
					
				}else{
					
					$response = "invalid";
					
				}
			
			}else{
				
				$response = $input;
				
			}
		}
		
		return $response;
		
	}
	
	// Amount in crypto
	
	function x_minorAmountInCrypto($currency , $amount_in_minor){
		
		$first = ["tbtc","btc","bch","ltc","doge"];
		$second = ["usdt@trx","trx"];
		
		$amount = $amount_in_minor;
		
		if(in_array($currency , $first)){
			
			$response = $amount / 100000000;
			
		}elseif(in_array($currency , $second)){
			
			$response = $amount / 1000000;
			
		}else{
			
			$response = 0;
			
		}
		
		return $response;
		
	}

	// Amount in minor
	
	function x_amountInMinor($currency , $amount_in_crypto){
		
		$first = ["tbtc","btc","bch","ltc","doge"];
		
		$second = ["usdt@trx","trx"];
		
		$amount = $amount_in_crypto;
		
		if(in_array($currency , $first)){
			
			$response = $amount * 100000000;
			
		}elseif(in_array($currency , $second)){
			
			$response = $amount * 1000000;
			
		}else{
			
			$response = 0;
			
		}
		
		return $response;
		
	}
	
	// Get transactions
	
	function x_getallAprWalletHistory($currency , $utoken , $wtoken){
	
	$wid = x_getsingleupdate("crypto_credentials","wallet_id","utoken='$utoken' AND wtoken='$wtoken' AND currency='$currency'");
	
	$wallet_id = x_unmaskInputs($wid , 20);
	
	$create = x_AprWalletHistory($wallet_id , "" , 10 , 0 , "" , "" , "" ,"");
		
	$decode = json_decode($create , true);	
	
	//print_r($decode);
	
		if(isset($decode["items"])){
			//echo "Total Records = ".count($decode["items"]);
			
			$total = count($decode["items"]); 
			
			if($total > 0){
				
				$allow = ["btc","ltc","bch","doge","tbtc"];
				$allowed = ["trx","usdt@trx"];
				
				?>
				
				<ul class="list-group">
				<li class="list-group-item p-2 fw-bold">Transaction History
				  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
					<?php
						if(isset($decode["pagination"])){
							
							echo $decode["pagination"]["total"];
							
						}
					?>
				  </span>

				</li>
				<?php
				$count = 0 ;
				for($i = 0 ; $i < $total ; $i++){
					$count++;
					$id = $decode["items"][$i]["id"];
					$type = $decode["items"][$i]["type"];
					$txs = $decode["items"][$i]["txs"][0];
					$status = $decode["items"][$i]["status"];
					$confirm = $decode["items"][$i]["is_confirmed"];
					$amt = $decode["items"][$i]["amount"];
					
					if(in_array($currency , $allow)){
						
						$value = $amt/100000000;
						
					}
					
					if(in_array($currency , $allowed)){
						
						$value = $amt/1000000;
						
					}
					
					
					if($confirm == "1"){
						
						$cf = "<span class='badge text-bg-success'>confirmed</span>";
						
					}else{
						
						$cf = "<span class='badge text-bg-primary'><div class='spinner-border spinner-border-sm text-white' role='status'><span class=''>unconfirmed</span></div></span>";
						
					}
					
					if($status == "success" && $type == "payment"){
						
						$status = "was successful.";
						
					}
					
					if($type == "payment"){
						
						?>
						<li style="font-size:9pt;" class="list-group-item p-2"><?php echo $count.". ";?>Transfer of <span class="fw-bold"><?php echo $value." ".strtoupper($currency);?></span> <?php echo $status." ".$cf;?></li>
						<?php
						
					}elseif($type == "receipt"){
						
						?>
							<li style="font-size:9pt;" class="list-group-item p-2"><?php echo $count.". ";?>Deposit of <span class="fw-bold"><?php echo $value." ".strtoupper($currency);?></span> <?php echo $cf;?></li>
						<?php
						
					}else{
						
						
					}

				}
				?></ul><?php
			}
			
		}
		
	}
	
	// Generate address qrcode
	
	function x_generateAddrQrcode($currency , $utoken , $wtoken){
		
		if(x_count("crypto_addresses","currency='$currency' AND wtoken='$wtoken' AND utoken='$utoken' LIMIT 1") > 0){
			
			foreach(x_select("wallet_address,qrcode_path","crypto_addresses","currency='$currency' AND wtoken='$wtoken' AND utoken='$utoken'","1","id") as $asset){
				
				$wid = $asset["wallet_address"];
				$qrcode = $asset["qrcode_path"];
				
				if($qrcode == ""){
					
					if(!is_dir("qraddress")){
						
							mkdir("qraddress");
							
						}
						
					$content = "$wid";
						
					$path = "qraddress/".$wtoken.md5($wid).$utoken.".png"; $path_validation = "1";
					
					x_qrcode($content,$path,$path_validation); // generate qrcode
					
					x_update("crypto_addresses","wtoken='$wtoken' AND utoken='$utoken' AND wallet_address='$wid'","qrcode_path='$path'","s","f");
						
					$npath = x_getsingleupdate("crypto_addresses","qrcode_path","wtoken='$wtoken' AND utoken='$utoken' AND wallet_address='$wid'");
					
					if($npath != ""){
						
						if(file_exists($npath)){
							
							$path = $npath;
							
						}else{
							
							$path = "assets/qrfail.png";
							
						}
					}else{
						
						$path = "assets/qrfail.png";
						
					}
					
				}else{
					
					if(file_exists($qrcode)){
						
							$path = $qrcode;
							
					}else{
						
							$path = "assets/qrfail.png";
						
					}
					
				}
				
				$server_status = x_getsingleupdate("server_status","status","id='1'");
				$site_url = x_getsingleupdate("site_setup","site_url","id='1'");
				$site_dir = x_getsingleupdate("site_setup","site_dir","id='1'");
				$link = "https://$site_url/$site_dir/";
				
				if($server_status == "live"){
						
						$exurl = $link;
						
				}else{
					
						$exurl = "";
					
				}
				
			  ?>
				
				
				
				<img src="<?php echo $exurl.$path;?>" style="width:200px;height:200px;" />
				
				<p style="font-size:11pt;font-weight:;"><?php echo $wid;?></p>
				<button onclick="showalert('wallet address copied');" data-clipboard-text="<?php echo $wid;?>" class="btn btn-primary btn-sm btn-addr"><i class="fa fa-copy"></i>&nbsp;&nbsp;Copy Address</button>
				
				
				<script>
				
					var clipboard = new ClipboardJS('.btn-addr');
					
					$(document).ready(function(){
						
						$("#show-screen").slideDown(500);
						
					});	
					
					
				</script>
				
			<?php
			}
			
		}
		
	}
	
	// in dollar alone
	
	function x_dollartocrypto($amount , $currency){
		
		$rate = x_AprExchangeRate($currency);
		
			$decode = json_decode($rate , true);
			
			if(isset($decode["usd"])){
				
				$rate = $decode["usd"];
				
			}else{
				
				$rate = 0;
				
			}
			
			if($rate == "0"){
				
				echo "Unstable internet | too many request";
				
				exit();
				
			}else{
				
				return $amount / round($rate,2);
				
			}
			
		
	}

	// in dollar alone
	
	/**function x_crytoindollar($currency){
		
		//sleep(7);
	
		$rate = x_AprExchangeRate($currency);
		
			$decode = json_decode($rate , true);
			
			if(isset($decode["usd"])){
				
				$rate = $decode["usd"];
				
			}else{
				
				$rate = 0;
				
			}
			
			return $rate;
		
	}***/
	
	// Rate 
	
	function x_crytoratenow($currency){
		
		//sleep(10);
		
		$rate = x_AprExchangeRate($currency);
		
			$decode = json_decode($rate , true);
			
			if(isset($decode["usd"])){
				
				$rate = number_format($decode["usd"],2);
				
			}else{
				
				$rate = "0";
				
			}
			
			
			if($rate == "0"){
				
				echo "Unstable internet | too many request";
				
				exit();
				
			}else{
				
				echo $rate ."USD";
				
			}
		
	}
	
	// create user wallet account
	
	function x_bpcryptowallet($currency, $uid , $utoken, $callbackurl , $is_forward , $destination_address , $n_fee , $pfp){
		
		$wtoken = wallettoken($utoken);
		
		if(x_count("crypto_credentials","currency = '$currency' AND utoken='$utoken' AND wtoken='$wtoken' LIMIT 1") > 0){}
		else{
			
			$timer = x_curtime(0,1); $status = "1";
			
			$create = x_AprsetupWallet($currency, $uid , $utoken, $callbackurl , $is_forward , $destination_address , $n_fee , $pfp);
		
			$decode = json_decode($create ,true);
			
			if(!isset($decode["wallet"])  || !isset($decode["transfer_key"])){
				
				x_toasts("Failed creating wallet");
				
			}else{
				
				$wallet_id = x_maskInputs($decode["wallet"],20);
				$transfer_key = x_maskInputs($decode["transfer_key"],20);
				
				x_insert("wallet_id , transfer_key , currency , wtoken , utoken , network_fee , processing_fee_policy , dated , status","crypto_credentials","'$wallet_id' , '$transfer_key' , '$currency' , '$wtoken' , '$utoken' , '$n_fee' , '$pfp' , '$timer' , '$status'","<script>showalert('wallet created for $currency');</script>","<script>showalert('Failed to create $currency wallet');</script>");
				
			}
			
		}
		
	}
	
// Add rand str at the end of another str

	function x_maskInputs($str,$length){
		if(isset($str) && !empty($str) && isset($length) && !empty($length)){
			if(is_numeric($length)){
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$generate = '';
				$generates = '';
				for ($i = 0; $i < $length; $i++) {
					$generate .= $characters[mt_rand(0, strlen($characters) - 1)];
					$generates .= $characters[mt_rand(0, strlen($characters) - 1)];
				}
				return $generates.$str.$generate;
			}
		}
	}

// Remove some part of a str

	function x_unmaskInputs($str,$length){
		if(isset($str) && !empty($str) && isset($length) && !empty($length)){
			if(is_numeric($length)){
				$rem = substr($str ,0 ,-$length);
				$rem = substr($rem ,$length);
				return $rem;
			}
		}
	}

/*****
 
 // Converting usd to btc 
	 function x_usd2btc($usd){
		$json =  xget("https://blockchain.info/tobtc?currency=USD&value=$usd");
		$decode = json_decode($json);
		return $decode;
	 }
 
 //Converting BTC to USD with formatting
 
	function x_btc2usd($btc){
		 $btc = @trim($btc);
		 $json =  xget("https://blockchain.info/ticker");
		 $decode = json_decode($json,true);
		 $onebtc = $decode["USD"]["last"];
		 $btc = $onebtc * $btc;
		 return number_format($btc,2);
		 
	 }
 
  //Converting BTC to USD no formatting
  
	function x_btc2usdnf($btc){
		 $btc = @trim($btc);
		 $json =  xget("https://blockchain.info/ticker");
		 $decode = json_decode($json,true);
		 $onebtc = $decode["USD"]["last"];
		 $btc = $onebtc * $btc;
		 return round($btc,2);
		 
	 }
 
 // Getting current Btc price in usd
 
	function x_btcprice($currency,$format){
		
		$json =  xget("https://blockchain.info/ticker");
		
		$decode = json_decode($json,true);
		
		if($format == 1){
			
			return strtoupper($currency)." ". number_format($decode[$currency]["last"],2);
			
		}
		
			return number_format($decode[$currency]["last"],2);
			
	 }***/

?>