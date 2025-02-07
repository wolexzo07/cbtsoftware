<?php
	
	if(!isset($ptoken)){
		
		exit();
		
	}
	
	include("supersu.php"); // Authenticating superuser
	
	// Generate reporting
	
	if($cmd == "generate-report"){
		
		//include("reportGenerationPro.php");
		
	}
	
?>