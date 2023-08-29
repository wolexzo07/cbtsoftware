	<?php
	include("validatingPage.php");
	
	if(x_validatesession("SESS_D_EXAM_BUTTON_MA")){
		
		finish("exams","0");
		exit();
		
	}
	?>
		
	<div class="clist-adjust">
	 
	 <?php
	 
		if(x_count("cross_platform_mode","id='1'") > 0){

			$p = x_getsingleupdate("cross_platform_mode","status","id='1'");
			
			if($p == "enable"){

			include("time_multiple_res.php");
			
			?>
			<p class="p-1 ls-2 g-color" style="float:left;font-size:11pt;text-transform:uppercase;">Select the correct subject and enter the subject 4-digit pin</p>
			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" onsubmit="return taken_exam()" autocomplete="off" method="POST">
				<?php include("select_multiple.php");?>
				<input type='password' placeholder='Enter pin' maxlength='4' required='required' class='pin' name='course_key'/>
				<input type='hidden' name='hid_key' value='token_key'/>
				<input type='submit' id='sublime' value='Take Selected Exam' class='gh'/>
			</form>
			<?php

			}
			
			if($p == "disable"){


			}

		}else{
			$msg="<b>No cross_platform_mode status</b>";
			echo $msg;
		}

	?>
	<script type='text/javascript'>
			function taken_exam(){
			
			var select = document.getElementById("selectt");
			
			if(select.value() == ''){
		
				document.getElementById('sublime').disabled=true;
				document.getElementById('sublime').value='You cannot re-take exam';
				return false;
				}
				return true;
			
			}
	</script>
	
  </div>
