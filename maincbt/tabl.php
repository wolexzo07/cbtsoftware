
<table style='background-color:;color:purple' width="100%" border="0px" cellpadding="5px" cellspacing="1px">
<tr>
<td align="left" valign="top" width="70%">

	<table cellpadding="10px" border="0px" cellspacing="0px" style="letter-spacing:3px;font-size:10pt;">

			<tr>
				<td><b>NAME</b> </td>
				<td><?php echo x_session("SESS_D_NAME_EXAM");?></td>
			</tr>

			<tr>
				<td><b>MAT. NO.</b></td>
				<td><?php echo x_session("SESS_D_USER_EXAM");?></td>
			</tr>

			<tr>
				<td><b>GENDER</b></td>
				<td><?php echo x_session("SESS_D_GENDER_EXAM");?></td>
			</tr>

			<tr>
				<td><b>LEVEL</b></td>
				<td><?php echo x_session("SESS_D_LEVEL_EXAM");?></td>
			</tr>


			<tr>
				<td><b>DEPART.</b></td>
				<td><?php echo x_session("SESS_D_DEPT_EXAM"); ?></td>
			</tr>

	</table>

</td>

<td align='left' valign="top" width='30%'>
	
	<?php
		if(x_count("control_profile","status='1' LIMIT 1") > 0){
			?>
				<img class="std-profile" src="<?php 
				$userid = x_clean(x_session("SESS_D_MEMBER_ID_EXAM"));
				$img = x_getsingleupdate("register","photo","id='$userid'");
				$placeholderimg = "image/avatar.png";
					if($img == ""){
						echo $placeholderimg;
					}else{
						if(file_exists($img)){
							echo $img;
						}else{
							echo $placeholderimg;
						}
					  }
				?>" />
				<?php
		}
	?>

</td>

</tr>
</table>

<style>
	.std-profile{
		width:120px;
		float:right;
		margin-right:20px;
		border-radius:50% 50%;
		-moz-border-radius:50% 50%;
		-webkit-border-radius:50% 50%;
		-o-border-radius:50% 50%;
		-ms-border-radius:50% 50%;
		box-shadow:3px 1px 3px black;
		-webkit-box-shadow:3px 1px 3px black;
		-moz-box-shadow:3px 1px 3px black;
	}
</style>