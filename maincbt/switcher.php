<?php
if(x_count("cross_platform_mode","id='1'") > 0){

	$p = x_getsingleupdate("cross_platform_mode","status","id='1'");
	
	if($p == "enable"){
		
		require("multiple_exam.php");
		
	}
	
	if($p == "disable"){

		if(x_validatesession("SESS_D_EXAM_BUTTON_MA")){
			
			finish("exams","0");
			
			}else{
			?>
				<img src="img/view_ex1.png" class="vewe1" onclick="parent.location='time_logon_go'"/>

			<?php
			}
	}
	
}else{

	$msg="<b>No cross_platform_mode status</b>";
	echo $msg;

}

?>
