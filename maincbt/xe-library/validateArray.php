<?php

	if(isset($data)){
		
		if(!is_array($data)){
			echo "<div class='alert alert-primary' role='alert'>Response has to be array</div>";
			exit();
		}
		
	}

	if(isset($extracted)){
		
		if(!is_array($extracted)){
			echo "<div class='alert alert-primary' role='alert'>Response has to be array</div>";
			exit();
		}
		
	}
	
	if(isset($json)){
		
		if(!is_array($json)){
			echo "<div class='alert alert-primary' role='alert'>Response has to be array</div>";
			exit();
		}
		
	}

?>