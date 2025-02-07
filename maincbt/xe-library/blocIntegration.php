<?php
	function x_getBlocBillerElect($category , $operatorID){ // Electricity plans
		$list = x_getBlocOperatorList($category , $operatorID);
		$data = json_decode($list , true);

		if(is_array($data)){
			
			if($data["success"] == "1"){
				
				if(isset($data["data"])){
					
					$dataList = $data["data"];
					
					?>
					<select name="productlist" required class="form-select" id="productlist">
						<?php
							for($i = 0 ; $i < count($dataList) ; $i++){
								
								$category_id = $dataList[$i]["category"];
								$product_id = $dataList[$i]["id"];
								$name = $dataList[$i]["name"];
								$operatorID = $dataList[$i]["operator"];
								
									?><option value="<?php echo $operatorID.'----'.$product_id.'----'.$category_id.'----'.$name;?>"><?php echo $name;?></option><?php
							}
						?>
					</select>
					
					<div class="col-12 mt-4">
						
						<input type="hidden" name="opid" id="opid" required="" value="<?php  echo $operatorID;?>"/>
						
						<input type="text" onpaste="validateSmartnumber(this.value , 'power')" onkeyup="validateSmartnumber(this.value , 'power')" required="" placeholder="Enter meter number" name="meter" id="meter-number" class="form-control"/>
						
						<div class="col-12 mt-3 validate-rex"></div>
						
					</div>
					<?php
				}
			}
			
			if($data["success"] != "1"){
				
				x_toasts("Failed to retrieve data");
				
			}
			
		}
		
	}

	function x_getBlocBillerTele($category , $operatorID){ // Television plans
		$list = x_getBlocOperatorList($category , $operatorID);
		$data = json_decode($list , true);

		if(is_array($data)){
			
			if($data["success"] == "1"){
				
				if(isset($data["data"])){
					
					$dataList = $data["data"];
					
					?><select name="productlist" required class="form-select mt-4" id="provider-type">
					<?php
					for($i = 0 ; $i < count($dataList) ; $i++){
						
						$category_id = $dataList[$i]["category"];
						$product_id = $dataList[$i]["id"];
						$name = $dataList[$i]["name"];
						$operatorID = $dataList[$i]["operator"];
						
						$currency = $dataList[$i]["meta"]["currency"];
						$amount = $dataList[$i]["meta"]["fee"];

						
							?><option value="<?php echo $operatorID.'----'.$product_id.'----'.$amount.'----'.$name;?>"><?php echo $name." | ".$currency." ".$amount;?></option><?php

					}
					?></select>
					
						<div class="col-12 mt-4">
							<input type="hidden" name="opid" id="opid" required="" value="<?php  echo $operatorID;?>"/>
							
							<input type="text" onpaste="validateSmartnumber(this.value , 'cable')" onkeyup="validateSmartnumber(this.value , 'cable')" required="" placeholder="Enter smart card number" maxlength="12" name="smartno" class="form-control smart-number-enable"/>
							
							<div class="col-12 mt-3 validate-rex"></div>
							
						</div>
					
					<?php
				}
			}
			
			if($data["success"] != "1"){
				
				x_toasts("Failed to retrieve data");
				
			}
			
		}
	}

	function x_getBlocBiller($category , $operatorID){
		$list = x_getBlocOperatorList($category , $operatorID);
		$data = json_decode($list , true);

		if(is_array($data)){
			
			if($data["success"] == "1"){
				
				if(isset($data["data"])){
					
					$dataList = $data["data"];
					?>
					<select name="productlist" required class="form-select mt-4" id="provider-type">
					<?php
					for($i = 0 ; $i < count($dataList) ; $i++){
						
						$category_id = $dataList[$i]["category"];
						$product_id = $dataList[$i]["id"];
						$name = $dataList[$i]["name"];
						$operatorID = $dataList[$i]["operator"];
						
						if($category_id == "pctg_ftZLPijqrVsTan5Ag7khQx"){ // filter out data alone
							
							$currency = $dataList[$i]["meta"]["currency"];
							$dataValue = $dataList[$i]["meta"]["data_value"];
							$amount = $dataList[$i]["meta"]["fee"];
						
							if(isset($dataList[$i]["meta"]["data_expiry"])){
								
								$dataExpiry = " | ".$dataList[$i]["meta"]["data_expiry"];
								
							}else{
								
								$dataExpiry = "";
								
							}
							
							?><option value="<?php echo $operatorID.'----'.$product_id.'----'.$amount.'----'.$name;?>"><?php echo $name." | ".$currency." ".$amount.$dataExpiry;?></option><?php
							
						}
					}
					?></select>
					
					<div class="col-12 mt-4">
						<input type="text" required="" placeholder="Enter phone number" name="phone" class="form-control"/>
					</div>
					
					<script>
						$(document).ready(function(){
							$(".enabled").removeAttr("disabled");
						});
					</script>
					<?php
				}
			}
			
			if($data["success"] != "1"){
				
				x_toasts("Failed to retrieve data");
				
			}
			
		}
	}
	
	
	function x_getBlocBillera($category , $operatorID){
		$list = x_getBlocOperatorList($category , $operatorID);
		$data = json_decode($list , true);

		if(is_array($data)){
			
			if($data["success"] == "1"){
				
				if(isset($data["data"])){
					
					$dataList = $data["data"];
					
					for($i = 0 ; $i < count($dataList) ; $i++){
						
						$category_id = $dataList[$i]["category"];
						$product_id = $dataList[$i]["id"];
						$name = $dataList[$i]["name"];
						$operatorID = $dataList[$i]["operator"];
						
						if($category_id == "pctg_xkf8nz3rFLjbooWzppWBG6"){ // filter out data alone
							
							$currency = $dataList[$i]["meta"]["currency"];
							$max = $dataList[$i]["meta"]["maximum_fee"];
							$min = $dataList[$i]["meta"]["minimum_fee"];
						
							if(isset($dataList[$i]["meta"]["data_expiry"])){
								
								$dataExpiry = " | ".$dataList[$i]["meta"]["data_expiry"];
								
							}else{
								
								$dataExpiry = "";
								
							}
							
							?>
						<input type="hidden" name="gems" value="<?php echo $product_id."----".$operatorID;?>"/>
						
						<div class="col-12 mt-4">
							<input type="text" required="" autocomplete="on" placeholder="Enter phone number" name="phone" class="form-control"/>
						</div>
						
						<div class="col-12 mt-4">
							<input type="number" required="" placeholder="Enter recharge amount" min="50" max="<?php echo $max;?>" name="amount" class="form-control"/>
						</div>
						
						<script>
						$(document).ready(function(){
							$(".enabled").removeAttr("disabled");
						});
						</script>
						
							<?php
							
						}
					}
					
				}
			}
			
			if($data["success"] != "1"){
				
				x_toasts("Failed to retrieve data");
				
			}
			
		}
	}
?>