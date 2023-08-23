<?php
  
  if(!isset($owner)){
	  echo "Token missing in <b>checked_c</b> file";
	  exit();
  }
  
  if(x_count("exams_scores","script_owner='$owner' AND attempted_num='$id' AND answer='c' LIMIT 1") > 0){
	  echo "checked='checked'";
  }
?>