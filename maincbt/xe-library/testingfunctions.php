<?php
function x_validatemail($email) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return false;
  }
  return true;
}
function x_getlargecsv($link, $file, $chunk_size, $queryValuePrefix, $callback)
{ // Handling large csv file
    try {
        $handle = fopen($file, "r");
        $i = 0;
        while (! feof($handle)) {
            call_user_func_array($callback, array(
                fread($handle, $chunk_size),
                &$handle,
                $i,
                &$queryValuePrefix,
                $link
            ));
            $i ++;
        }
        fclose($handle);
    } catch (Exception $e) {
        trigger_error("file_get_contents_chunked::" . $e->getMessage(), E_USER_NOTICE);
        return false;
    }

    return true;
}

function x_compressimg($source_url, $destination_url, $quality){ //compressing image size
  $info = getimagesize($source_url);
 
  if ($info['mime'] == 'image/jpeg')
    $image = imagecreatefromjpeg($source_url);
 
  elseif ($info['mime'] == 'image/gif')
    $image = imagecreatefromgif($source_url);
 
  elseif ($info['mime'] == 'image/png')
    $image = imagecreatefrompng($source_url);
 
  imagejpeg($image, $destination_url, $quality);
  return $destination_url;
}


function x_acctvalidator($acctnumb){ // Nigeria bank account validator
	if(x_justvalidate($acctnumb)){
		if((strlen($acctnumb) == 10) && is_numeric($acctnumb)){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function x_strexplode($str , $separator , $index){
	if(($str == "") || ($index == "") || !is_numeric($index)){
		$result = "One argument not supplied:: x_strexplode(string , separator ,arrayindex)";
		if(isset($index)){
			$range = range(0,100); // array list of number 1-100
			if(!in_array($index,$range) || !is_numeric($range)){
				$result = "index argument must be a number:: x_strexplode(string , separator ,arrayindex)";
			}
		}
		
		if(isset($str) && ($str == "")){
			$result = "string argument not supplied:: x_strexplode(string , separator ,arrayindex)";
		}
		
	}elseif(($str == "") && ($index == "")){
		$result = "All arguments are missing :: x_strexplode(string , separator ,arrayindex)";
	}elseif($separator == ""){
		$result = "separator arguments is missing :: x_strexplode(string , separator ,arrayindex)";
	}else{
		$splitname = explode($separator,$str);
		$counter = count($splitname);
		if($index < $counter){
			$result = $splitname[$index];
		}else{
			$result = "invalid index in use";
		}
	}
	return $result;
}
?>