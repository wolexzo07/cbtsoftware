<?php
		function x_splname($str){ // splitting name
			$strg = @trim($str);
			$split = explode(" ",$strg);
			return x_trunc($split[0],0,20);
		}
?>