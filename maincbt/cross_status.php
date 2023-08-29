<?php
if(x_count("cross_platform_mode","id='1'") > 0){
	$p = x_getsingleupdate("cross_platform_mode","status","id='1'");
	if($p == "disable"){
		x_update("register","username='$owner'","access='revoked'","Account access updated","Failed to update account access");
	}
}
?>

