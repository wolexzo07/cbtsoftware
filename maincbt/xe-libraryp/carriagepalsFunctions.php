<?php
	function x_phasher($str){
		$salt = "ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvxyzTimBoss2023?@#?<>";
		$hash = sha1($str.$salt).md5($str.$salt);
		return $hash;
	}
	
	function x_toasts($str){
		?>
		<script>
			showalert("<?php echo $str;?>");
		</script>
		<?php
	}
	
	function x_crwbalance($switch , $userid){ // get current balance in ngn & usd
		if($switch == "USD"){
			$switched = "wallet_usd";
		}else{
			$switched = "wallet_ngn";
		}
		
		$balance = x_getsingleupdate("manageaccount","$switched","id='$userid'");
		return $balance;
	}
	
	function x_balsufficient($currency , $inputamount , $userid){ // check for sufficiency in balance
		$ubalance = x_crwbalance($currency , $userid);
		
		if($inputamount > $ubalance){
			$diff = number_format($inputamount - $ubalance,2);
			x_toasts("Oops :: Insufficient balance to perform transaction! Add $currency $diff");
			exit();
		}else{
			return true;
		}
	}
	
	function x_refgen($userid){
		$hash = substr(sha1(uniqid().$userid),0,10).str_shuffle($userid.DATE("YmdHis")).$userid;
		return $hash;
	}
	
	function x_valdimension($dimen){ // validating dimension (Lenght X Breadth X Height)
		
		if(x_justvalidate($dimen)){
			
			if(substr_count($dimen,"x") == 2 || substr_count($dimen,"X") == 2){
				
				if(substr_count($dimen,"x") == 2){
					$split = explode("x",$dimen);
				}
				if(substr_count($dimen,"X") == 2){
					$split = explode("X",$dimen);
				}
				
				$counter = count($split);
				
				if($counter == 3){
					
					if(is_numeric($split[0]) && is_numeric($split[1]) && is_numeric($split[2])){
						
						return $split[0]." x ".$split[1]." x ".$split[2];
					
					}else{
						x_toasts("Invalid dimension input");
						exit();
					}
					
				}else{
					x_toasts("Invalid dimension input");
					exit();
				}
				
			}else{
				x_toasts("Invalid dimension input");
				exit();
			}
			
		}
		
	}
?>