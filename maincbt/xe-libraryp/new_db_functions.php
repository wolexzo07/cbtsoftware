<?php
function x_countupdate($table,$where,$limit){
	
	if($where == "0"){
		$sele ="SELECT COUNT(*) as obey FROM $table";
	}elseif($where == "01"){
		$sele ="SELECT COUNT(*) as obey FROM $table LIMIT 1";
		}else{
		$sele ="SELECT COUNT(*) as obey FROM $table WHERE $where";
	}

	if(!$read = x_connect($sele)){
	$msg = "Failed to query db";
	return $msg;
	}else{
	$assoc = mysqli_fetch_assoc($read);
	$num = $assoc["obey"];
	return $num;
	}
}

function x_max($what,$table,$where){
	
	$limit = x_count($table,$where);
	
	if($limit > 0){
		
			if(($where == "0")){
				$sele ="SELECT MAX($what) as highest FROM $table LIMIT $limit";
			}else{
				$sele ="SELECT MAX($what) as highest FROM $table WHERE $where LIMIT $limit";
			}

			if(!$read = x_connect($sele)){
			$msg = "Failed to query db";
			return $msg;
			}else{
			$assoc = mysqli_fetch_assoc($read);
			$num = $assoc["highest"];
			return $num;
			}
	}else{
		return 0;
	}
}
?>