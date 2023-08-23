<?php
  
  if(!isset($owner)){
	  echo "Token missing in <b>checked</b> file";
	  exit();
  }
  
  if(x_count("exams_scores","script_owner='$owner' AND attempted_num='$id' AND answer='a' LIMIT 1") > 0){
	  echo "checked='checked'";
  }
?>