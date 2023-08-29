<?php
	session_start();
	include("xe-library/xe-library74.php");
	if(x_validatesession("course_session") && x_validateget("cmd") && x_validateget("pnum")){
		
		$cmd = xg("cmd");
		$pn = xg("pnum");
		$csubject = x_clean(x_session("course_session"));
		
		if($cmd == "goto"){ // manage goto pager
			
			if(x_count("subject_pin","subject='$csubject'") > 0){
			
			$total_sub = x_getsingleupdate("subject_pin","allocated_question","subject='$csubject'");
			
			if(x_justvalidate($total_sub) && is_numeric($total_sub)){
				
				for($i=1 ; $i < $total_sub+1 ; $i++){
					if($pn == $i){
						?>
						<option selected="" value="<?php echo $i;?>"><?php echo "Question - ".$i;?></option>
						<?php
					}else{
						?>
						<option value="<?php echo $i;?>"><?php echo "Question - ".$i;?></option>
						<?php
					}
					
			
				}
			}
			
		  }
			
		}
		
	}

?>