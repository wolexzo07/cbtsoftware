<?php
		function x_splname($str){ // splitting name
		
			$strg = @trim($str);
			
			$split = explode(" ",$strg);
			
			return x_trunc($split[0],0,20);
			
		}
		
       function x_getsingleresult($table,$column,$where){
			
			if(x_count("$table","$where LIMIT 1") > 0){
				
				foreach(x_select("$column","$table","$where","1","$column") as $key){
					
					$response = $key["$column"];
					
				}
				
			}else{
				
				$response = "invalid";
				
			}
			
			if(isset($response)){
				
				return $response;
				
			}
		
		}
?>