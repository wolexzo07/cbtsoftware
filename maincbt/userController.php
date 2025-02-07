<?php
	
	if(!isset($ptoken)){
		
		exit();
		
	}
	
	
	if($cmd == "wallet-getall"){
		
		include("walletGetallBalances.php");
	
	}

?>