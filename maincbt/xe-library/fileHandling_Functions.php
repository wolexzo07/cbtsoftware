<?php
	function x_checkuploadstatus($val){ // checking upload status
	
		if($val == ""){
			x_print("File variable not available!");
		}else{
			
			if(is_uploaded_file($_FILES[$val]['tmp_name'])){
				$message = "file"; //file was uploaded | nfile=not file
				return $message;
				//return true;
			}else{
				$message = "nfile"; //no file was uploaded | nfile=not file
				return $message;
				//return false;
			}

		}
}

function x_vimgdimens($maxWidth , $maxHeight , $uploadVariable){

	if (isset($_FILES[$uploadVariable]) && $_FILES[$uploadVariable]['error'] === UPLOAD_ERR_OK) {
		
		$uploadedFile = $_FILES[$uploadVariable]['tmp_name'];
		
		list($width, $height) = getimagesize($uploadedFile);
		
		if($width <= $maxWidth && $height <= $maxHeight) {
			
			$response = "valid"; // image conformed to rules
			
		}else{
			
			$response = "invalid"; // image exceeded allowed size
			
		}
		
	}else{
		
		$response = "error"; // error uploading image
	}
	
	return $response;

}

function x_checkuploadsize($val,$maxsize){ // check file upload size
	if(($val == "") || ($maxsize == "")){
		x_print("Specify file variable or max upload size");
		exit();
	}elseif(!is_numeric($maxsize)){
		x_print("Max upload size must be numeric!");
		exit();
	}else{
		$calc = $maxsize;  //converting to byte
		$size = $_FILES[$val]['size'];
		if($size > $calc){
			$er = x_getsize($calc);
			$message = "exceeded"; // file size was exceed
			return $message;
		
		}
	}	
}


function x_checkuploadextension($allowed_ext,$variable){ // check file upload extension
	if(($allowed_ext == "") || ($variable == "")){
		x_print("File extension missing or variable not available!");
		exit();
	}else{

		$pray = explode(",",$allowed_ext);
		$vao = explode(".",$_FILES[$variable]['name']);
		$ext = strtolower(end($vao));
		
		if(!in_array($ext,$pray)){
			$message = "nallowed"; // invalid file extensions | nallowed = not allowed
			return $message;
		}
	}
	
}


function x_checkpath($val,$loc){
	if(($val == "") || (($loc == ""))){
		x_print("File target location or variable cannot be empty!");
		exit();
	}else{
		
		$locc = $loc.$_FILES[$val]['name'];
		if(file_exists($locc)){
			$message = "exist"; // file path exist
			return $message;
		}
	}
	
}

function x_pushupload($val,$loc,$file_exists){
	
	if(($val == "") || (($loc == ""))){
		
		x_print("File target location or variable cannot be empty!");

	}else{
		
		$vb = $_FILES[$val]['tmp_name'];
		$locc = $loc.$_FILES[$val]['name'];
		
		if($file_exists == "1"){
			
			if(file_exists($locc)){
				x_print("File already exist at the targeted location!");
				exit();
			}
			
		}else{
			
			return move_uploaded_file($vb,$loc);
			
		}
	}
}

function x_spath($val,$dir,$salt){ // salted path
	return $dir."/".$salt.sha1($_FILES[$val]['name']).".".x_file("$val");
}

?>