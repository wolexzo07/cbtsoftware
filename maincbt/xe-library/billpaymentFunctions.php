<?php
		
		function x_bpAdminChecker($wtoken , $utoken){ // Admin checker
			if(x_count("smanup","wtoken='$wtoken' AND utoken='$utoken' AND status='1' LIMIT 1") > 0){
				 return 1;
			}else{
				return 0;
			}
		}


		function x_bpUchecker($utoken , $uid){ // user checker
		
			if(x_count("manageaccount","id='$uid' AND token='$utoken' LIMIT 1") > 0){
				
				 return 1;
				 
			}else{
				
				return 0;
				
			}
		}
		
		
		function x_pinHash($str){
			 $str = trim($str);
			 $salt = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz?@?#";
			 $hash = md5($str).md5($salt);
			 return $hash;
		}
		
		
		function x_tweakmail($email , $mobile){
					$extract = explode("@",$email);
					$part = $extract[0];
					$parttwo = $extract[1];
					return $part."-$mobile"."@".$parttwo;
		}
				
				
		function bp_mailer($title,$content,$user_email){
			
			if(file_exists("../siteinfo.php")){
				
				require("../siteinfo.php");
				
			} else {
				
				require("siteinfo.php");
				
			}
			
			$date = Date("Y"); $titl = strip_tags($title); $subject = "$sitename : $titl";
			$message = "
				<html>
					<head>
						<title>$subject</title>
					</head>
					<body>
						<table cellpadding='20px' cellspacing='0px' border='0px' style='border:1px solid lightgray;' width='100%'>
							<thead>
								<tr style='background:white'>
								<th><center><img src='https://$siteurl/blocapp/$sitelogo' alt='BILLS PILOT' style='width:250px;'/></center></th>
								</tr>
							</thead>
							<tbody>
								<tr>
								<td>
								$content
								</td>
								</tr>
							</tbody>
							<tfoot>
								<tr style='background:white;'>
									<td>
									Thank you for choosing us<br/>
									From <b>$sitename Team</b>
									</td>
								</tr>
								<tr style='background:white;'>
									<td>
									<h4 >CONTACT US THROUGH:</h4>
									<p style='font-weight:bold;'>Email : <a style='text-decoration:none;'>$siteemail</a></p>
									<p style='font-weight:bold;color:;'>Phone 1 :  $phone1</p>
									<p style='font-weight:bold;color:;'>Phone 2 :  $phone2</p>	
									<p style='text-align:center;border-top:1px solid lightgray;padding-top:12px;margin-top:12px;'>Powered by <b><a style='text-decoration:none;color:;'>$siteurl</a> &copy; $date</b></p>
									</td>
								</tr>
							</tfoot>

						</table>

					</body>
				</html>";
			
			if(x_count("control_mail","status='1'") > 0){
				
					if(sendmail($user_email,$subject,$message) == 0){
						$msg="<script type='text/javascript'>alert('Mailing Failed!')</script>";
										echo $msg;
						}	
				}			
	}
	
	
	function bp_notifier($type,$title,$message,$utoken,$category){
		
		$filter = array("p","all","admin","biz");
		
		$filter_cat = array('withdraw','transfer','credit','debit','refund','airtime','data','cable','power','gov-bill','internet');
		
		if(in_array($type,$filter) && in_array($category,$filter_cat)){
			
			$success = "0"; $failed = "<p>Failed to notify #$utoken</p>";
			
			$stime = x_curtime(0,0); $rtime = x_curtime(0,1);
			
			$message = x_clean($message);	$title = x_clean($title);
			
			if(x_count("notifications_controller","status='1'") > 0){
				
				if(($type == "admin") && ($utoken == "")){
					
					x_insert("category,type,title,message,status,stime,rtime","notifyme","'$category','$type','$title','$message','0','$stime','$rtime'","$success","$failed");
					
				}else{
					
					$wtoken = wallettoken($utoken);
					
					x_insert("category,type,title,message,utoken,wtoken,status,stime,rtime","notifyme","'$category','$type','$title','$message','$utoken','$wtoken','0','$stime','$rtime'","$success","$failed");
					
				}
				
			}	
		} else {
			
			echo "missing notifier parameter";
			
		}
	}
	
	
	function auth_token($ptoken){
		
		if(!isset($ptoken)){
			exit();
		}
		
	}
	
	function x_getRef($userid){
		
		$ref = $userid.time().DATE("Ymdhis").strtoupper(uniqid());
		return "ACCT-".str_shuffle($ref);
	}
	
	function x_billref($userid){
		
		$ref = $userid.time().DATE("Ymdhis").strtoupper(uniqid());
		return "BL-".str_shuffle($ref);
	}
	
	function x_getbpwBalances($currency , $utoken , $userid){ // wallets balances
		
		if(x_count("manageaccount","id='$userid' AND token='$utoken' LIMIT 1") > 0){ // check user id
			
			$allowed = array("ngn","usd","gbp","eur");
			
			$wtoken = wallettoken($utoken);
			
			if(x_count("bpilot_wallets","wtoken='$wtoken' LIMIT 1") > 0){ // checking if wallet is active
				
				if(in_array($currency,$allowed)){
					
					$balance = x_getsingleupdate("bpilot_wallets","wallet_$currency","wtoken='$wtoken' AND is_status='1'");
					
					if(is_numeric($balance)){
						
						$response = $balance;
						
					}else{
						
						$response = 0;
						
					}
					
					return $response;
				}	
			}
			
		}
	}
	
	function wallettoken($str){
		return sha1($str).md5($str);
	}
		
	function x_passhasher($pass){
		$salt = "ABCDEFGHIJKKLMNOPQ1234567890abcghdtuwioalkjsnh?@";
		$hash = md5(sha1($pass).$salt).sha1(sha1($pass).$salt);
		return $hash;
	}
	
	function f_name($str){ // formatting name
		return x_clean(ucwords(strtolower($str)));
	}

	function f_email($email){
		
		if(empty($email)){
			
			$response = "empty";
			
		}else{
			
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			
				$response = "invalid";
		  
			}else{
				
			  $response = x_clean(strtolower($email)); // is_valid email
				
			}
			
		}
		
		return $response;
		
	}
	
	function x_uniqtoken($email){
		return sha1($email.uniqid()).md5($email.uniqid());
	}
	
	function x_validateTeleProvider($phonenumber){ // MTN , GLO , AIRTEL , 9MOBILE  

		$mtn_prefix = array("0803" , "0703" , "0903" , "0806" , "0706" , "0813" , "0810" , "0814" , "0816" , "0903" , "0906" , "0913" , "0916");

		$glo_prefix = array("0805" , "0905" , "0811" , "0815" , "0705" , "0807" , "0915");

		$airtel_prefix = array("0802" , "0808" , "0701" , "0708" , "0702" ,"0902" , "0907" , "0901", "0812" , "0911" , "0912");

		$ninemobile_prefix = array("0809" , "0909" , "0817" , "0818" , "0908");
		
		if(isset($phonenumber) && !empty($phonenumber)){
			
			if(strlen($phonenumber) !== 11){ // invalid telecom number lenght
				
				$response = "INVALID";
				
			}else{ // valid telecom number lenght
		
				$numpart = substr($phonenumber,0,4);
				
				if(in_array($numpart , $mtn_prefix)){
					
					$response = "MTN";
					
				}elseif(in_array($numpart , $glo_prefix)){
					
					$response = "GLO";
					
				}elseif(in_array($numpart , $airtel_prefix)){
					
					$response = "AIRTEL";
					
				}elseif(in_array($numpart , $ninemobile_prefix)){
					
					$response = "9MOBILE";
					
				}else{
					
					$response = "UNKNOWN";
					
				}
			}
			return $response;
		}
			
}


?>