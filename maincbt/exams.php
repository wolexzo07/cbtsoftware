<?php
	include_once("auth.php");
	include_once("siteinfo.php");
	$tokenizer = sha1(uniqid());
?>
	<html>
		<head>
			<?php
			include("head_b.php");
			?>
			<title><?php echo strtoupper($sitename);?> - <?php echo strtoupper($_SESSION['SESS_D_NAME_EXAM']);?> EXAMINATION PAGE</title>
			
		</head>
	<body>
		<script type="text/javascript" src="js/controls.js"></script>

		<div class="container pt-5">
			<div class="header d-none">
				<center>
				<?php //include("logobase.php");?>
				</center>
			</div>
		
		
		<!-- manage profile photo--->
		<?php include_once("control_profile.php");?>
		
		<div id="erf">
		
		<div class="welcome-msg">
		Hi, <b> 
		<?php 
			if($_SESSION['SESS_D_USER_EXAM'] != ""){
				//echo $_SESSION['SESS_D_USER_EXAM']. "&nbsp;&nbsp;(".$_SESSION['SESS_D_NAME_EXAM'].")";
				
				echo x_trunc($_SESSION['SESS_D_NAME_EXAM'],0,30);
				
				}else{
					echo $_SESSION['SESS_D_MAT_NO_EXAM'];
					} 
		?> </b> 
		&nbsp;| &nbsp;<img src='image/logout.png' onmouseover="tooltip.pop(this, '#demo3_tip')" class='logout' style='width:20px' onclick="shu()"/>&nbsp;&nbsp;&nbsp;
		</div>


		<fieldset class="fdii">
		
		<legend><img src="img/ep.png" class="selL1"/></legend>
		
		
		
		<table width="100%" cellpadding="10px" cellspacing="10px" border="0px">
		
			<tr><td width="86%" valign="top">

				<?php 

					if(x_count("mode","id='1' LIMIT 1") > 0){
						
						$stat = x_getsingleupdate("mode","status","id='1'");
						
						if($stat == "essay_mode"){
							
							include("pagination_e.php");
						
						}else{
							
							include("pagination.php");
						
						}

					}else{
						
						echo "No mode found";
						
					}
				?>
			</td>
			
			<td width="" valign="top">
			
			
			<!---Timer panel-->
			
			<div class="timeclass" id="timeclasse"></div>
			
			<!--------Goto Page------------>
			
			<?php include("pager.php");?>
			
			<div id="log"></div>
			<div id="logi"></div>

			
			<!--------Qrcode image-------------->
			
			<img src="img/e2850cce504f13b86304e7126a9b006e16734a98.png" style="width:120px;display:none;"/>

			<script type="text/javascript" src="js/calc.js"></script>

			<img class="pot mt-2 mb-2" src="../download.png" style="width:30px;display:block;"/>
			
			<!--------End Examination button-------------->
			
			<img src="img/end.png" onclick="parent.location='changer?token=<?php echo sha1(rand(6000 , 1000000));?>'" class="end-btn"/>

			</td>
			</tr>
		</table>
		<!-- manage control button--->
		<?php include_once("btn_ctlr.php");?>

		</fieldset>

			<div id="calc_loader">
					<?php require_once("../calc2/extra.html");?>
			</div>

		</div>
		
		<div style="display:none;">
			<?php
				if(x_count("tooltips","id='1'") > 0){
					foreach(x_select("tooltip","tooltips","id='1'","1","id") as $key){
						$info = $key["tooltip"];
						echo " ".$info;
					}
				}else{
					
				}
			?>		 
		 </div>
					 
		<div id="footer">

		</div>
		
	  </div>
			
			<script src="shutdown.js"></script>
			<script src="logit.js"></script>
			<script src="adax.js"></script>
			
    </body>

</html>
