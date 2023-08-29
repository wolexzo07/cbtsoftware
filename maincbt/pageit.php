<?php
include("finishit.php");

	if(x_validatepost("page")){
		
		$pag = xp("page");
		$cp = 1;
		
		if(!is_numeric($pag)){
			finish("exams?pn=$cp","Enter a valid page number!");
		}else{
			finish("exams?pn=$pag","0");
		}
		
	}
	else{
		finish("exams?pn=1","Parameter missing!");	
	}
	
?>