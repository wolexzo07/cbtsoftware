<?php
	#Errand Pilot Functions
	
	function ep_proofid(){
		if(x_count("proofid","status='1' LIMIT 1") > 0){
			?><option value="">Means of identification</option><?php
			foreach(x_select("means,value","proofid","status='1'","10","id asc") as $proof){
				$means = $proof["means"];
				$value = $proof["value"];
				?>
				<option value="<?php echo $value;?>"><?php echo $means;?></option>
				<?php
			}	
		}
	}
	
	function ep_getbyid($uid,$what_to_get){
		$realpath = x_getsingleupdate("manageaccount","$what_to_get","id='$uid'");
		return $realpath;
	}
	
	function x_deletePath($filepath){ // delete files from paths
	
	 if(x_justvalidate($filepath)){
	 
		if(file_exists($filepath)){
			$result = unlink($filepath);
		}else{
			$result = "Invalid path :: x_deletePath(filepath)";
		}
		
	 }else{
		$result = "Invalid usage :: x_deletePath(filepath)";
	 }
		return $result;
	}
	
	function x_validatePath($path,$dummypath){ // validating images files path
		if(isset($path) && x_justvalidate($dummypath)){
			if($path == ""){
				$result = $dummypath;
			}elseif(!file_exists($dummypath)){
				$result = "Invalid usage :: Dummypath missing!";
			}else{
				if(file_exists($path)){
					$result = $path;
				}else{
					$result = $dummypath;	
				}	
			}
		}else{
			$result = "Invalid usage :: x_validateimg(path,dummypath)";
		}
		return $result;
	}
	
	function x_getsingleupdate($table,$column_name,$extrasql){
		if(x_count("$table","$extrasql LIMIT 1") > 0){
			$sql = x_getsingle("SELECT $column_name FROM $table WHERE $extrasql LIMIT 1","$table WHERE $extrasql LIMIT 1","$column_name");
		}else{
			$sql = "Invalid queries";
		}
		return $sql;
	}
		

			// send mails
	function ep_mailer($title,$content,$user_email){
			if(file_exists("../siteinfo.php")){
				require("../siteinfo.php");
			}else{
				require("siteinfo.php");
			}
		$date = Date("Y");
		$titl = strip_tags($title);
		$subject = "$sitename : $titl";
		$message = "
		<html>
		<head>
		<title>$subject</title>
		</head>
		<body>

		<table cellpadding='20px' cellspacing='0px' border='0px' style='border:1px solid lightgray;' width='100%'>
		<thead>
		<tr style='background:aqua'>
		<th><center><img src='https://$siteurl/$sitelogo' style='width:250px;'/></center></th>
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
		<tr>
		<td>
		Thank you for choosing us<br/>
		From <b>$sitename Team</b>
		</td>
		</tr>
		<tr style='background:green;color:white;'>
		<td>
		<h4 style='color:white;'>CONTACT US THROUGH:</h4>
		<p style='font-weight:bold;color:white;'>Email : <a style='text-decoration:none;color:white;'>$siteemail</a></p>
		<p style='font-weight:bold;color:white;'>Phone 1 :  $phone1</p>
		<p style='font-weight:bold;color:white;'>Phone 2 :  $phone2</p>	
		<p style='text-align:center;border-top:1px solid lightgray;padding-top:10px;'>Powered by <b><a style='text-decoration:none;color:white;'>$siteurl</a> &copy; $date</b></p>
		</td>
		</tr>
		</tfoot>

		</table>

		</body>
		</html>
		";
		
		if(x_count("control_mail","status='1'") > 0){
			
				if(sendmail($user_email,$subject,$message) == 0){
					$msg="<script type='text/javascript'>alert('Mailing Failed!')</script>";
									echo $msg;
					}	
			}			
	}
	
	 // Getting Alert message
	function ep_alert_error($msg , $colorshortcode ,$fa_icon){
		print "<div class='alert alert-$colorshortcode text-center'><i class='fa fa-$fa_icon' style='font-size:60pt;'></i><br/><br/> $msg</div>";
	}
	
	// Manage notification
	function ep_notifier($type,$title,$message,$userid,$category){
		$filter = array("p","all","admin","biz");
		$filter_cat = array('credit','debit','refund','create','fulfil','ship','deliver','cancel');
		if(in_array($type,$filter) && in_array($category,$filter_cat)){
			$success = "&nbsp;";
			$failed = "<p>Failed to notify #$userid</p>";
			$stime = x_curtime(0,0);
			$rtime = x_curtime(0,1);
			$message = x_clean($message);$title = x_clean($title);
			if(x_count("notifications_controller","status='1'") > 0){
				if(($type == "admin") && ($userid == "")){
					x_insert("category,type,title,message,userid,status,stime,rtime","notifyme","'$category','$type','$title','$message','0','0','$stime','$rtime'","$success","$failed");
				}else{
					x_insert("category,type,title,message,userid,status,stime,rtime","notifyme","'$category','$type','$title','$message','$userid','0','$stime','$rtime'","$success","$failed");
				}
			}	
		}else{
			echo "missing notifier parameter";
		}
	}
	
		// fetch user wallet balance
	
		function ep_walletBal($userToken){
		 $result = x_getsingle("SELECT wallet_balance FROM manageaccount WHERE token='$userToken' LIMIT 1","manageaccount WHERE token='$userToken' LIMIT 1","wallet_balance");
		 return $result;
		}

		function ep_getDetails($userToken,$column){
		 $result = x_getsingle("SELECT $column FROM manageaccount WHERE token='$userToken' LIMIT 1","manageaccount WHERE token='$userToken' LIMIT 1","$column");
		 return $result;
		}

		function generate(){
			$email = xp("email");
			$dater = DATE("mdHis"); 
			$hash = substr(strtoupper(sha1($email)),0,4);
			$add = strtoupper(xrands(10));
			return $dater."-".$hash."-".$add;
		}
		
		function x_generated($param){
			$email = $param;
			$dater = DATE("mdHis"); 
			$hash = substr(strtoupper(sha1($param)),0,4);
			$add = strtoupper(xrands(10));
			return $dater."-".$hash."-".$add;
		}
		
		function eptoks($str){
			return sha1($str).md5($str);
		}
		
		function epbal($token,$opt){
			$options = array("w","b","c");
			$userhash = eptoks($token);
			if(in_array($opt,$options)){
				if(x_count("ep_wallets","utoken='$userhash' LIMIT 1") > 0){
					foreach(x_select("wallet_balance,wallet_bonus,wallet_credit","ep_wallets","utoken='$userhash'","1","id") as $balance){
						$w = $balance["wallet_balance"];
						$b = $balance["wallet_bonus"];
						$c = $balance["wallet_credit"];
					}
					if($opt == "w"){
						return $w;
					}elseif($opt == "b"){
						return $b;
					}else{
						return $c;
					}
				}else{
					x_print("invalid wallet!");
				}
			}else{
				x_print("invalid wallet option!");
			}
		}

?>