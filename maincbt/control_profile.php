<?php
include("validatingPage.php");
if(x_count("control_profile","status='1' LIMIT 1") > 0){
		?>
			<img id="preimg" src="<?php 
			$userid = x_clean(x_session("SESS_D_MEMBER_ID_EXAM"));
			$img = x_getsingleupdate("register","photo","id='$userid'");
			$placeholderimg = "image/avatar.png";
				if($img == ""){
					echo $placeholderimg;
				}else{
					if(file_exists($img)){
						echo $img;
					}else{
						echo $placeholderimg;
					}
				  }
			?>" />
			<?php
 }
?>