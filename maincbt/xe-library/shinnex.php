<?php
	
	function currentConnection(){
		
		return switchState("l"); // l | p 
		
	}
	
	function sh_decodeCrDBValue($wallet){
		
		$wl = ["BTC","USDT","ETH"];
		
		if(!in_array($wallet,$wl)){
			
			echo "wallet not supported";
			
			exit();
		}
		
		if($wallet == "BTC"){
			
			$response = "btc_addr";
			
		}
		
		if($wallet == "ETH"){
			
			$response = "eth_addr";
			
		}
		
		if($wallet == "USDT"){
			
			$response = "usdt_addr";
			
		}
		
		if(isset($response)){
		
			return $response;
				
		}
		
	}
	
	
	function sh_validatepass($uid , $pass){
		
		$pass = sh_pass($pass);
		
		if(x_count("createusers","id='$uid' AND passkey='$pass' LIMIT 1") > 0){
			
			$response = '1';
			
		}else{
			
			$response = '0';
			
		}
		
		return $response;
		
	}
	
	
	function passRestCode($generated){
		
		return md5($generated."Tim").sha1("Tim".$generated);
		
	}
	

	function sh_convertUnameToUid($username){
		
		
		$uid = x_getsingleupdate("createusers","id","username='$username'");
		
		return $uid;
		
	}
	
	function sh_reformat($str){
		
		$split = explode(" " , $str);
		$first = $split[0];
		$second = $split[1];
		
		if(in_array($first , ["NGN","GHS","KSH"])){
			
			$response = "<span style='font-size:17pt;'>$first</span> ".$second;
			
		}
		
		if(in_array($second , ["BTC","USDT","ETH"])){
			
			$response = $first." <span style='font-size:17pt;'>$second</span>";
			
		}
		
		if(isset($response)){
			
			return $response;
			
		}else{
			
			return $str;
			
		}
		
	}
	
	function sh_validateAddress($address, $type) {
		
		$allow = ["btc","eth","usdt"];
		
		if(!in_array($type,$allow)){
			
			die("Invalid option (eth|btc|usdt).");
			
		}
		
		if ($type == 'btc') {
			
			if (preg_match('/^(1|3|bc1)[A-Za-z0-9]{25,39}$/', $address)) {
				
				$response = 1;
				
			}else{
				
				$response = 0;
				
			}
		}
		
		if ($type == 'eth') {
			
			if (preg_match('/^0x[a-fA-F0-9]{40}$/', $address)) {
				
				$response = 1;
				
			}else{
				
				$response = 0;
				
			}
		}
		
		if ($type == 'usdt') {
			
			if (preg_match('/^T[a-zA-Z0-9]{33}$/', $address) || preg_match('/^0x[a-fA-F0-9]{40}$/', $address)) {
				
				$response = 1;
				
			}else{
				
				$response = 0;
				
			}
		}

		if(isset($response)){
			
			return $response;
			
		}
	}


	function sh_getIdNameEmail($uid , $opt){ // get id , email , name , mobile , username
		
		$allow = ["n","e","i","m","u"];
		
		if(!in_array($opt,$allow)){
			
			die("Invalid option (e|n|i|m|u).");
			
		}
		
		if(x_count("createusers","id='$uid' LIMIT 1") > 0){
			
			foreach(x_select("id , email , name , mobile,username","createusers","id='$uid'","1","id") as $logger){
				
				$email = $logger["email"]; $name = $logger["name"]; $mobile = $logger["mobile"]; $id = $logger["id"];
				
				$user = $logger["username"];
				
			}
			
			if($opt == "i"){
				
				$response = $id;
				
			}

			if($opt == "n"){
				
				$response = $name;
				
			}

			if($opt == "e"){
				
				$response = $email;
				
			}
			
			if($opt == "m"){
				
				$response = $mobile;
				
			}
			
			if($opt == "u"){
				
				$response = $user;
				
			}
			
			return $response;
			
		}
		
	}
	
	
	function sh_notify($user_id , $title , $message , $type , $tranxType){
		
		$allowed = ["all","p","admin"];
		
		$tranxAllow = ["","sell","buy","gift","withdraw","topup","newuser"];
		
		$date = x_curtime(0,1); $dated = x_curtime(0,0);
		
		if(in_array($type , $allowed) && in_array($tranxType , $tranxAllow)){
			
			 $title = x_clean($title); $message = x_clean($message);
			
			x_insert("tranx_type , user_id ,type,title,message,status,date_time,time_stamp","notification","'$tranxType','$user_id','$type','$title','$message','0','$date','$dated'","0","0");
			
		}
		
	}
	
	function sh_mailer($to , $title , $content){
		
		$subject = $title;
		$urlimg = "https://yungopay.com/realapp/img/cryptlogo.png";
		$siteemail = "support@yungopay.com";
		$message = "
			<html>
				<head>
				<title>$title</title></title>
				</head>
				<body>

					<table cellpadding='10px' cellspacing='0px' border='1px' style='border:1px solid lightgray;' width='100%'>
						<thead>
						<tr style='background:white;border-bottom:1px solid black;'>
						<th><center><img src='$urlimg' style='width:250px;'/></center></th>
						</tr>

						</thead>
						<tbody style='background:white;'>
							<tr>
								<td>
									$content
								</td>
							</tr>
						</tbody>
						<tfoot style='background:white;'>
							<tr>
								<td>
								Thank you for choosing YungoPay<br/>
								From <b>Yungopay Team</b>
								</td>
							</tr>
							<tr style='background:DodgerBlue;color:white;'>
								<td>
									<h4>KINDLY CONTACT US THROUGH:</h4>
									<p>Email :  <a style='text-decoration:none;color:white;'>$siteemail</a></p>
									
								</td>
							</tr>
						</tfoot>

					</table>

				</body>
			</html>";
		
			if(sendmail($to,$subject,$message) == "1"){
				
				$response = "success";
				
			}else{
				
				$response = "failed";
				
			}
			
			return $response;
	}
	
	function sh_uidStatus($opt){
		
		if($opt == "1"){
			?>
			<span class="badge badge-b">Active</span>
			<?php
		}
		
		if($opt == "2"){
			?>
			<span class="badge badge-r">suspended</span>
			<?php
		}

		if($opt == "0"){
			?>
			<span class="badge badge-black">Inactive</span>
			<?php
		}
		
	}
	
	function sh_timeAgo($datetime , $timezone = 'UTC') {

		$dateTimeZone = new DateTimeZone($timezone);

		$datetime = new DateTime($datetime, $dateTimeZone);
		$now = new DateTime('now', $dateTimeZone);
		$interval = $now->diff($datetime);
		if ($interval->y > 0) {
			return $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
		} elseif ($interval->m > 0) {
			return $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
		} elseif ($interval->d > 0) {
			return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
		} elseif ($interval->h > 0) {
			return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
		} elseif ($interval->i > 0) {
			return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
		} else {
			return 'just now';
		}
	}

	
	function sh_strip($input, $tagsToStrip) {
	
		$tagsToStripString = implode(',', array_map(function($tag) {
			return '<' . $tag . '>';
		}, $tagsToStrip));

		return strip_tags($input, $tagsToStripString);
	}
	
	function sh_walletApprx($wallet , $amount){
		
		if(!in_array($wallet ,["NGN","GHS","KSH","USDT","ETH","BTC"])){
			echo "invalid wallet";
			exit();
		}
		
		if($wallet == "BTC"){
			
			$response = round($amount , 6);
			
		}


		if($wallet == "ETH"){
			
			$response = round($amount , 6);
			
		}

		if($wallet == "USDT"){
			
			$response = round($amount , 2);
			
		}
		
		if($wallet == "NGN"){
			
			$response = round($amount , 2);
			
		}


		if($wallet == "GHS"){
			
			$response = round($amount , 2);
			
		}

		if($wallet == "KSH"){
			
			$response = round($amount , 2);
			
		}
		
		return $response;
		
	}
	
	function sh_checkifBankFilled($wallet , $userid){
		
		$wdetails = sh_getUserAcctWalletdb($wallet);
		
		if(x_count("createusers","id='$userid' LIMIT 1") > 0){
			
			foreach(x_select("$wdetails","createusers","id='$userid'","1","id") as $details){}
			
			foreach(explode(",",$wdetails) as $key){
				
				$wd = trim($details["$key"]);
				
				if($wd == ""){
					
					$getemp[] = 1;
					
				}else{
					
					$getemp[] = 0;
					
				}
				
			}
			
			$summation = array_sum($getemp);
			
			if($summation > 0){
				
				$response = 0; // no record found
				
			}
			
			if($summation <= 0){
				
				$response = 1; // record found
				
			}
			
			if(isset($response)){
				
				return $response;
				
			}
	
		}
		
	}
	
	function sh_getUserAcctWalletdb($wallet){
		
		if(!in_array($wallet , ["NGN","GHS","KSH","BTC","ETH","USDT","ALLCRYPTO"])){
			
			$response = "invalid wallet";
			
		}else{
		
			if($wallet == "NGN"){
				
				$response = "bank_name,acct_number,acct_name";
				
			}
			
			if($wallet == "GHS"){
				
				$response = "momo_acctname,momo_acctnumb,momo_id";
				
			}
			
			if($wallet == "KSH"){
				
				$response = "ksh_acctname,ksh_acctnum,ksh_bankname";
				
			}
			
			
			if($wallet == "BTC"){
				
				$response = "btc_addr";
				
			}
			
			
			if($wallet == "ETH"){
				
				$response = "eth_addr";
				
			}
			
			if($wallet == "USDT"){
				
				$response = "usdt_addr";
				
			}

			if($wallet == "ALLCRYPTO"){
				
				$response = "btc_addr,eth_addr,usdt_addr";
				
			}
		}
		
		if(isset($response)){
			
			return $response;
			
		}
		
	}
	
	function sh_giftcardTranxID($userid){ // gift card tranx id
		
		return "GID-".str_shuffle(strtoupper(uniqid().DATE("YmdHis")).$userid);
		
	}

	function sh_withTranxID($userid){ // withdrawal id
		
		return "WD-".str_shuffle(strtoupper(uniqid().DATE("YmdHis")).$userid);
		
	}
	
	function sh_trTranxID($userid){ // Transfer id
		
		return "TR-".str_shuffle(strtoupper(uniqid().DATE("YmdHis")).$userid);
		
	}
	
	function sh_convertUsdToAll($transType , $rateamt){ // convert usd to all (fiat && crypto)
		
		$allowed = ["KSH","GHS","NGN","USD","USDT","BTC","ETH"];
		
		$fiat = ["KSH","GHS","NGN","USD"];
		
		$crypt = ["USDT","BTC","ETH"];
		
		if(!in_array($transType , $allowed)){
			
			$response = "Invalid tranx Type";
			
		}else{

			if(in_array($transType , $crypt)){ // converting USD TO CRYPTO
				
				$response = sh_convertusdcrypt("$transType" , $rateamt); 
				
			}

			if(in_array($transType , $fiat)){ // converting USD TO FIAT
				
				$response = sh_walletCurrentRate("$transType" , $rateamt , "3"); 
				
			}
			
			
		}
		
		if(isset($response)){
			
			return $response;
			
		}
		
	}
	
	
	function sh_convertusdcrypt($input , $amount){
		
		$asset = strtolower($input);
		
		if($asset == "usdt"){
			
			$asset = "usdt@trx";
			
		}
			
		$rate = x_crytoindollar("$asset");
		
		if($rate == "0"){
			
			echo "Please check internet";
			
			exit();
		}
		
		if($asset == "usdt@trx"){
			
			$final = round($amount / $rate,2);
			
		}else{
			
			$final = round($amount / $rate,4);

		}
		
		return $final;
		
	}
	
	function sh_reform($wallet , $amount){
		
		$fiat = ["KSH","GHS","NGN","USD"];
		
		$crypt = ["USDT","BTC","ETH"];
		
		if(in_array($wallet , $fiat)){
			
			$response = $wallet." ".number_format($amount,2);
			
		}

		if(in_array($wallet , $crypt)){
			
			$response = sh_walletApprx($wallet,$amount)." ".$wallet;
			
		}
		
		if(isset($response)){
			
			return $response;
			
		}
		
	}
		
	function sh_status($statusOpt){
		
		if($statusOpt == "0"){
			
			$rep = "pending";
			
		}
		
		if($statusOpt == "1"){
			
			$rep = "approved";
			
		}
		
		if($statusOpt == "2"){
			
			$rep = "cancelled";
			
		}
		
		return $rep;
			
	}
		
		
	function sh_pass($pass){
		
		return md5($pass).md5("GraceofGod2020?");
		
	}
	

	
	function switchState($opt){
		
		$allowed = ["l","p"];
		
		if(in_array($opt,$allowed)){
			
			if($opt == "l"){
				
				$url = "https://localhost/shina/realapp/";
				
			}

			if($opt == "p"){
				
				$url = "https://yungopay.com/realapp/";
				
			}
			
			return $url;
			
		}
		
	}
	
	function sh_switchMyAddrs($asset){ // switch admin crypto addr
		
		$allowed = ["BTC","ETH","USDT"];
		
		if(in_array($asset , $allowed)){
			
			if($asset == "BTC"){
				
				$response = "btc_addr";
				
			}

			if($asset == "ETH"){
				
				$response = "eth_addr";
				
			}

			if($asset == "USDT"){
				
				$response = "usdt_addr";
				
			}
			
		}else{
			
			$response = "invalid asset";
			
		}
		
		if(isset($response)){
			
			return $response;
			
		}
		
	}
	
	function sh_getAllfiatcrList(){ // get all fiat/crypto
		
		if(x_count("fiat_crypto","status='1' LIMIT 1") > 0){
			
			foreach(x_select("name","fiat_crypto","status='1'","10","id desc") as $data){
				
				$name = $data["name"];
				
				?>
					<option value="<?php echo $name;?>"><?php echo $name;?></option>
					
				<?php
				
			}
			
		}else{
			
			?>
				<option value="">No response</option>
				
			<?php
			
		}
		
	}
	
	function sh_listFiatCryptBal($type , $userid){ // list fiat / crypto balance in combo
		
		if($type == "f"){
			
			$typee = "fiat";
			
		}elseif($type == "c"){
			
			$typee = "crypto";
			
		}else{
			exit();
		}
		
		if(x_count("fiat_crypto","type='$typee' AND status='1' LIMIT 1") > 0){
			
			foreach(x_select("id , name , symbol","fiat_crypto","type='$typee' AND status='1'","4","id desc") as $data){
				
				$id = $data["id"];
				$name = $data["name"];
				$sym = $data["symbol"];
				
				
				if($type == "f"){
					?>
						<option value="<?php echo $name;?>">
						
							<?php echo  $name." ".number_format(x_getbalance($sym,$userid),2);?>
							
						</option>
					<?php
					
				}
				
				if($type == "c"){
					
					if($name == "USDT"){
						
						$apprx = 2;
						
					}else{
						
						$apprx = 8;
					}
					?>
						<option value="<?php echo $name;?>">
						
							<?php //echo  number_format(x_getbalance($sym,$userid),$apprx)." ".$name;?>
							<?php echo  $name." ~ ".sh_walletApprx($name,x_getbalance($sym,$userid))." ".$name;?>
							
						</option>
					<?php
				}
				
			}
			
		}else{
			
			?>
				<option value="">No response</option>
				
			<?php
			
		}
		
	}

	function sh_genTrxbyid($userid , $prefix){  // Buying / Selling Tranx id generator
			
			return $prefix.str_shuffle($userid.DATE("YmdHis").$prefix.strtoupper(uniqid()));;
			
		}
		
	function sh_getCryptoFiatdb($fiat){ // Get fiat-crypto db-value
		
		  if(isset($fiat)){
			
			if($fiat == "NGN"){
				
				$wid = "naira_wallet";
				
			}elseif($fiat == "GHS"){
				
				$wid = "cedis_wallet";
				
			}elseif($fiat == "KSH"){
				
				$wid = "cephas_wallet";
				
			}elseif($fiat == "USD"){
				
				$wid = "dollar_wallet";
				
			}elseif($fiat == "BTC"){
				
				$wid = "btc_wallet";
				
			}elseif($fiat == "USDT"){
				
				$wid = "usdt_wallet";
				
			}elseif($fiat == "ETH"){
				
				$wid = "eth_wallet";
				
			}else{exit();}
			
			if(isset($wid)){
				
				return $wid;
				
			}else{
				
				return "fiat missing!";
				
			}
			
		}
	}

	function sh_getCryBalancebyUid($fiat , $userid){ // Get fiat | crypto balance by user id
		
		if(isset($fiat)){
			
			if($fiat == "NGN"){
				
				$wid = "naira_wallet";
				
			}
			
			if($fiat == "GHS"){
				
				$wid = "cedis_wallet";
				
			}
			
			if($fiat == "KSH"){
				
				$wid = "cephas_wallet";
				
			}
			
			if($fiat == "USD"){
				
				$wid = "dollar_wallet";
				
			}
			
			if($fiat == "BTC"){
				
				$wid = "btc_wallet";
				
			}
			
			if($fiat == "USDT"){
				
				$wid = "usdt_wallet";
				
			}
			
			if($fiat == "ETH"){
				
				$wid = "eth_wallet";
				
			}
			
			if(isset($wid)){
				
				return x_getbalance("$wid","$userid");
				
			}else{
				
				return "fiat missing!";
				
			}
			
		}
	}
	
	function sh_getFiatBalancebyUid($fiat , $userid){ // Get fiat | crypto balance by user id
		
			return sh_getCryBalancebyUid($fiat , $userid);
			
	}
	
	function sh_validateuser($uid){ // validating user
		
		if(x_count("createusers","id='$uid' LIMIT 1") > 0){
			
			$response = 1;
			
		}else{
			
			$response = 0;
			
		}
		
		return $response;
		
	}
	
	function sh_walletCurrentRate($wallet , $amountInUsd , $mode){ // Getting local currency against dollar (buy | sell rate)
		
		$list = ["NGN","GHS","KSH","USD"];
		
		if(in_array($wallet , $list)){
			
			if(x_count("rates","fiat_type='$wallet'") > 0){
				
				foreach(x_select("buy_rate AS br, sell_rate AS sr","rates","fiat_type='$wallet'","1","id") as $rate){
					
					$br = $rate["br"]; // buying rate
					$sr = $rate["sr"]; // selling rate
					
				}
				
				
				if($mode == "0"){ // return buy | sell
					
					$response = $br."-".$sr;
					
				}

				if($mode == "1"){ // return buy rate
					
					$response = $br;
					
				}

				if($mode == "2"){ // return sell rate
					
					$response = $sr;
					
				}


				if($mode == "3"){ // return buy rate x $amountInUsd
					
					$response = $br * $amountInUsd;
					
				}

				if($mode == "4"){ // return sell rate x $amountInUsd
					
					$response = $sr * $amountInUsd; 
					
				}
				
			}else{
				
				$response = "Rate record missing!";
				
			}
			
		}else{
			
			$response = "Fiat invalid";
			
		}
		
		if(isset($response)){
			
			return $response;
			
		}
		
	}
	
	
	
	function sh_getRatenCon($wallet , $amountInCrypt , $mode){ // Get currenct rate of crypto and conversion
		
		if($wallet == "BTC"){
			
			$cur = strtolower($wallet);
			
		}
		
		if($wallet == "ETH"){
			
			$cur = strtolower($wallet);
			
		}
		
		if($wallet == "USDT"){
			
			$cur = "usdt@trx";
			
		}
		
		if($mode == "0"){
			
			$response = x_crytoindollar("$cur");
			
		}
		
		if($mode == "1"){
			
			$response = x_crytoindollar("$cur") * $amountInCrypt;
			
		}
		
		if(isset($response)){
			
			return $response;
			
		}
		
	}
	
	
	function sh_checkingTrxStatus($tid , $token , $statusOpt){ // validating transaction status
		
		if($statusOpt == "0"){
			
			$rep = "pending";
			
		}
		
		if($statusOpt == "1"){
			
			$rep = "approved";
			
		}
		
		if($statusOpt == "2"){
			
			$rep = "cancelled";
			
		}
		
		if(!isset($rep)){
			
			return "Variable is missing!";
			
			exit();
		}
		
		if(x_count("transaction","tranx_id='$tid' AND token='$token' AND status='$statusOpt'") > 0){
			
			$response = 1;
			
		}else{
			
			$response = 0;
			
		}
		
		return $response;
	
	}

	function sh_checkingTrx($tid , $token , $opt){ // validating transaction & alert record
		
		if($opt == "0"){
			
			$rep = "alertus";
			
		}
		
		if($opt == "1"){
			
			$rep = "transaction";
			
		}
		
		if(!isset($rep)){
			
			return "Variable is missing!";
			
			exit();
		}
		
		if(x_count("$rep","tranx_id='$tid' AND token='$token'") > 0){
			
			$response = 1;
			
		}else{
			
			$response = 0;
			
		}
		
		return $response;
	
	}
	
	function statusSwch($status){ // status switch
		
			if($status == "0"){
						
				$code = "Pending";
						
			}
					
			if($status == "1"){
				
				$code = "Approved";
				
			}
			
			if($status == "2"){
				
				$code = "Cancelled";
				
			}
			
			if(isset($code)){
				
				return $code;
				
			}
		
	}
	
	function fiatSwitches($fiat){
		
		if($fiat == "NGN"){
			
			$wid = "naira_wallet";
			
		}elseif($fiat == "GHS"){
			
			$wid = "cedis_wallet";
			
		}elseif($fiat == "KSH"){
			
			$wid = "cephas_wallet";
			
		}elseif($fiat == "USD"){
			
			$wid = "dollar_wallet";
			
		}else{exit();}
		
		return $wid;
	}
	
	

	
	function sh_getallFiatCrypt($type , $showOptions){ // get all fiat/crypto
		
		if($type == "f"){
			
			$type = "fiat";
			
		}elseif($type == "c"){
			
			$type = "crypto";
			
		}else{
			exit();
		}
		
		if(x_count("fiat_crypto","type='$type' AND status='1' LIMIT 1") > 0){
			
			foreach(x_select("id , name , symbol","fiat_crypto","type='$type' AND status='1'","4","id desc") as $data){
				
				$id = $data["id"];
				$name = $data["name"];
				$symbol = $data["symbol"];
				
				
				if($showOptions == "0"){
					?>
						<option value="<?php echo $name;?>"><?php echo $name;?></option>
					<?php
					
				}elseif($showOptions == "1"){
					?>
						<option value="<?php echo $id.'---'.$name.'--'.$symbol;?>"><?php echo $name;?></option>
					<?php
				}else{
					exit();
				}
				
			}
			
		}else{
			
			?>
				<option value="">No response</option>
				
			<?php
			
		}
		
	}
	
	//get all fiat rate
	
	function sh_fiatrates($currency){
		
		$allowed = ["NGN","GHS","KSH","ALL"];
		
		if(in_array($currency , $allowed)){
			
			if($currency == "ALL"){
				
				  if(x_count("rates","status='1' LIMIT 1") > 0){
				
						foreach(x_select("fiat_type,buy_rate,sell_rate","rates","status='1'","3","id") as $key){
							$buyat = $key["buy_rate"];
							$sellat = $key["sell_rate"];
							$fiat = $key["fiat_type"];
							
							$getall[] = $fiat."---".$buyat."---".$sellat;
						}
						
						$response = $getall;
						
					}else{
						
						$response = "No rate set for $currency";
						
					}
				
			}else{
				
					if(x_count("rates","fiat_type='$currency' AND status='1' LIMIT 1") > 0){
				
						foreach(x_select("buy_rate,sell_rate","rates","fiat_type='$currency' AND status='1'","1","id") as $key){
							$buyat = $key["buy_rate"];
							$sellat = $key["sell_rate"];
						}
						
						$response = $currency."---".$buyat."---".$sellat;
						
					}else{
						
						$response = "No rate set for $currency";
						
					}
				
			}
			
	
			
		}else{
			
			$response = "invalid fiat option";
		}
		
		return $response;
		
	}
	
	//re-format crypto
	
	function sh_rates($currency){
		
		$rate = x_crytoindollar($currency);
		
		return "$ ".number_format($rate , 2);
	}

	
	// Auto select fiat wallet
	
	function sh_autoFiat($fiat , $userid){
		
		if(isset($fiat)){
			
			if($fiat == "NGN"){
				
				$wid = "naira_wallet";
				
			}elseif($fiat == "GHS"){
				
				$wid = "cedis_wallet";
				
			}elseif($fiat == "KSH"){
				
				$wid = "cephas_wallet";
				
			}elseif($fiat == "USD"){
				
				$wid = "dollar_wallet";
				
			}else{}
			
			if(isset($wid)){
				
				echo "$fiat ".number_format(x_getbalance("$wid",$userid),2);
				
			}else{
				
				echo number_format(0,2);
				
			}
			
		}else{
			
			echo number_format(0,2);
			
		}
	}
	
	// Getting balance in dollar
	
	function sh_getdollarbal($userid , $wallet){
		
		if($wallet == "btc"){
			
			$mw = "btc_wallet";
			$cur = $wallet;
			
		}
		
		if($wallet == "eth"){
			
			$mw = "eth_wallet";
			$cur = $wallet;
			
		}
		
		if($wallet == "usdt"){
			
			$mw = "usdt_wallet";
			$cur = $wallet."@trx";
			
		}
		
		$getbal = x_getbalance("$mw",$userid);
		
		$res = x_crytoindollar("$cur") * $getbal;
		
		return "$ ".number_format($res , 2);
		
	}
	
	// admin access checker

	function sh_adminchecker($uid){
			$getrole  = x_getsingleupdate("createusers","role","id='$uid'");
			return $getrole;		
	}
?>