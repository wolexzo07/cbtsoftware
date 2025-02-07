<?php
	function x_getPRTnameById($id){ // get staff position-role-title name by id 
		$name = x_getsingleupdate("optionslisting","name","id='$id'");
		return $name;
	}
	
	function x_getphotodimens($switch , $options){ // get photo dimensions from db
		
		$allowed = array("p","s","sf"); // s=student | p=parent | sf=staff
		
		if(in_array($switch , $allowed)){
			
			if($switch == "sf"){
				$type = "staff";
			}
			
			if($switch == "s"){
				$type = "student";
			}
			
			if($switch == "p"){
				$type = "parent";
			}
			
			if($options == "w"){
				$opt = "width";
			}
			
			if($options == "h"){
				$opt = "height";
			}
			
			if(x_justvalidate($opt) && x_justvalidate($type)){
				$response = x_getsingleupdate("photo_dimension","$opt","type='$type'");
				return $response;
			}else{
				x_toasts("Code Error:: parameter missing!");
				exit();
			}
			
			
		}else{
			x_toasts("Invalid parameter:: (p | s | sf allowed)");
			exit();
		}
			
	}
	
	
	function x_getRPTListing($switch){ // Getting role , position and title listing
		
		$allowed = array("p","r","t"); // r=role | p=position | t=title
		
		if(in_array($switch , $allowed)){
			
			if($switch == "t"){
				
				if(x_count("optionslisting","type='title' AND status='1'") > 0){
					
					foreach(x_select("id,name","optionslisting","type='title' AND status='1'","30","id") as $title){
						$id = $title["id"];
						$name = $title["name"];
						echo "<option value='$id'>$name</option>";
					}
				
				}else{
					
						echo "<option>No available title</option>";
					
				}
				
			}elseif($switch == "p"){
				
				if(x_count("optionslisting","type='position' AND status='1'") > 0){
					
					foreach(x_select("id,name","optionslisting","type='position' AND status='1'","30","id") as $position){
						
						$id = $position["id"];
						$name = $position["name"];
						
						echo "<option value='$id'>$name</option>";
					}
				
				}else{
					
						echo "<option>No available position</option>";
					
				}	
				
			}else{

				if(x_count("optionslisting","type='role' AND status='1'") > 0){
					
					foreach(x_select("id,name","optionslisting","type='role' AND status='1'","30","id") as $role){
						
						$id = $role["id"];
						$name = $role["name"];
						
						echo "<option value='$id'>$name</option>";
					}
				
				}else{
					
						echo "<option>No available role</option>";
					
				}					
				
			}
			
			
		}else{
			x_toasts("Invalid parameter:: (r | p | t allowed)");
			exit();
		}
		
	}
	
	function x_getStdClassById($switch , $cid){ // Getting class & section by id
		
		$allowed = array("cl","cs"); // cl=class | cs=class section | $cid=cl/cs id
		
		if(in_array($switch , $allowed)){
			
			if($switch == "cl"){
				
				$response = x_getsingleupdate("classes","class_title","id='$cid'");
				
			}else{
				
				$response = x_getsingleupdate("class_section","class_section","id='$cid'");
			}
			
			return $response;
			
		}else{
			x_toasts("Invalid parameter:: (cl | cs allowed)");
			exit();
		}
		
	}
	
	
	function x_contactControl($switch , $value){ // validating std contact acceptance
		
		$allowed = array("em","mob");
		
		if(in_array($switch , $allowed)){
			
			if($switch == "em"){
				$rm = "email";
				$tb = "is_email_compulsory";
			}
			
			if($switch == "mo"){
				$rm = "mobile";
				$tb = "is_mobile_compulsory";
			}
			
			$getstatus = x_getsingleupdate("contact_entry_control","$tb","status='1'");
			
			if($getstatus == "1"){
				
				if($value == ""){ // checking if value is not available
					x_toasts("$rm field is missing!");
					exit();
				}
				
				if($switch == "email"){
					if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
						x_toasts("kindly provide valid $rm!");
						exit();
					}	
				}
				
				if(x_count("student_data","$rm='$value' LIMIT 1") > 0){
					x_toasts("$rm $value already taken!");
					exit();
				}
				
			}
			
		}else{
			x_toasts("Invalid parameter:: (mob | em allowed)");
			exit();
		}
	}
	
	function x_getList($switch , $extraOptions){ // fetching classes & class sections
		
		if($extraOptions == ""){
			
			$extraOptions = "status='1'";
			
		}elseif($extraOptions == "" && $switch=="se"){
			
			$extraOptions = "status='active'";
			
		}else{
			
			$extraOptions = $extraOptions;
			
		}
		
		$allowed = array("cl","cs","pd","dorm","rt","se"); // cl=classes | cs=class section | pd=parent | dorm=dormitory | rt=route | se=session
			
			if(in_array($switch,$allowed)){
				
				if($switch == "cs"){
					
						if(x_count("class_section","$extraOptions") > 0){
		
							foreach(x_select("id,class_section,class_nickname","class_section","$extraOptions","100","class_section") as $row){
								$classid = $row['id'];
								$class = $row['class_section'];
								$cn = $row['class_nickname'];
								echo "<option value='$classid' class='optn'>$class &nbsp;&nbsp;($cn)</option>";
							}
							
						}else{
							
							echo "<option class='optn'>No available class section</option>";
							
						}
					
				}
				
				if($switch == "cl"){
					
						if(x_count("classes","$extraOptions") > 0){
							
							foreach(x_select("id,class_title,class_nickname","classes","$extraOptions","100","class_title") as $row){
								$classid = $row['id'];
								$class = $row['class_title'];
								$cn = $row['class_nickname'];
								echo "<option value='$classid' class='optn'>$class &nbsp;&nbsp;($cn)</option>";
							}
							
						}else{
							
							echo "<option class='optn'>No class available</option>";
							
						}
					
				}
				
				if($switch == "pd"){
					
					if(x_count("parent_data","$extraOptions") > 0){
						
						foreach(x_select("username , name , id","parent_data","$extraOptions","1000","name") as $row){
							$id = $row['id'];
							$user = $row['username'];
							$name = $row['name'];
							echo "<option value='$id' class='optn'>$name ( $user )</option>";
							
						}
						
					}else{
						
						echo "<option class='optn'>No parent available</option>";
						
					}
					
				}
				
				if($switch == "dorm"){
					
					if(x_count("dormitory","$extraOptions") > 0){
						
						foreach(x_select("id,dormitory_title","dormitory","$extraOptions","100","dormitory_title") as $row){
							$id = $row['id'];
							$dorm = $row['dormitory_title'];
							echo "<option value='$id' class='optn'>$dorm</option>";	
						}
						
					}else{          
						echo "<option class='optn'>No dormitory available</option>";
					}
					
				}
				
				if($switch == "rt"){
					if(x_count("route","$extraOptions") > 0){
						
						foreach(x_select("id,route_name","route","$extraOptions","500","route_name") as $row){
							$id = $row['id'];
							$rt = $row['route_name'];
							echo "<option value='$id' class='optn'>$rt</option>";	
						}
						
					}else{     
					
						echo "<option class='optn'>No route available</option>";
						
					}					
				}
				
				if($switch == "se"){
					
					if(x_count("session","status='active'") > 0){
		
						foreach(x_select("id,session","session","status='active'","50","session") as $row){
							$id = $row['id'];
							$se = $row['session'];
							echo "<option value='$id' class='optn'>$se Session</option>";	
						}
						
					}else{          
					
						echo "<option class='optn'>No session available</option>";
						
					}	
				}
				
				
			}else{
				
				echo "invalid switch : cl | cs allowed";
				
			}
	}
	
	
	function x_readCounter($switch){ // counting teacher , parent and students data
			$allowed = array("s","t","p");
			
			if(in_array($switch,$allowed)){
				
				if($switch == "p"){
					$data = "parent_data";
				}
				if($switch == "t"){
					$data = "staff_data";
				}
				if($switch == "s"){
					$data = "student_data";
				}
				
				$count = x_count("$data","01");
				return $count;
			}else{
				return 0;
			}
		}
		
	function ordinal($num)
	  {
		$last=substr($num,-1);
		if( $last>3  or 
			$last==0 or 
			( $num >= 11 and $num <= 19 ) )
		{
		  $ext='th';
		}
		else if( $last==3 )
		{
		  $ext='rd';
		}
		else if( $last==2 )
		{
		  $ext='nd';
		}
		else 
		{
		  $ext='st';
		}
		return $num.$ext;
	  }
	  
	function ordinall($i)
	{
		$l = substr($i,-1);
		$s = substr($i,-2,-1);
		 
		return (($l==1&&$s==1)||($l==2&&$s==1)||($l==3&&$s==1)||$l>3||$l==0?'th':($l==3?'rd':($l==2?'nd':'st')));
	}
	
	function x_phashsch($str){
		$salt = "timothytheinvincibleprogrammer1234?1990@";
		$hash = x_clean(md5(sha1($str.$salt)));
		return $hash;
	}
	
?>