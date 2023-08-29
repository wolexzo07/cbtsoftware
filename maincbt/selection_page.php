<?php
include("auth.php");
include("siteinfo.php");
?>
<html>
<head>
<?php
include("head_b.php");
?>
<title><?php echo strtoupper($sitename);?> - PROFILE DETAILS & EXAMINATION INSTRUCTIONS | <?php echo strtoupper(x_session("SESS_D_NAME_EXAM"));?></title>
</head>
<body>
<div id="container">

		<center>
			<?php include("logobase.php");?>
		</center>

<div id="bd">

<table cellspacing="10px" width="100%" cellpadding="10px" border="0px">
<tr>

<td valign="top" width="65%" >
<p><?php include("time_display.php")?></p>

<?php
	include("instruction_fetch.php");
?>

<center>
	<?php 
 include("switcher.php");
	?>

	
	</center>


</td>

<td valign="top" width="35%" >

<fieldset class="fdi">
<legend></legend>

<p style='padding:5pt;'>


Hi <b> 
<?php 
	if(x_session("SESS_D_NAME_EXAM") != ""){
		$str = x_session("SESS_D_NAME_EXAM");
		echo x_splname($str);
	}
?> </b> 
&nbsp;| &nbsp;<img src='image/logout.png'  class='logout' style='width:20px' onclick="return(shu())"/>
</p>


<table width="100%" border="0" cellpadding="5px" cellspacing="5px">

<tr>
<td >
<b>Name</b>
</td>
<td >

<?php
echo $_SESSION['SESS_D_NAME_EXAM'];
?>
</td>
</tr>


<tr>
<td>
<b>Level</b>
</td>
<td>

<?php
echo $_SESSION['SESS_D_LEVEL_EXAM'] ;
?>
</td>
</tr>
<tr>
<td>
<b>
Dept</b>
</td>
<td>

<?php
echo $_SESSION['SESS_D_DEPT_EXAM'] ;
?>
</td>
</tr>

<tr>
<td>
<b>Gender</b>
</td>
<td>

<?php
echo $_SESSION['SESS_D_GENDER_EXAM'];
?>
</td>
</tr>

<!--<tr>
<td>
<b>OS</b>
</td>
<td>

<?php
echo $_SESSION['OPERATING_SYSTEM_IUOCBT'];
?>
</td>
</tr>

<tr>
<td>
<b>IP</b>
</td>
<td>

<?php
echo $_SESSION['HTTP_IUOCBT'];
?>
</td>
</tr>-->

</table>



</fieldset>


<?php

// Result publishing Button Manager Started

if(x_count("result_button","status='enable' LIMIT 1") > 0){
	$user = x_clean($_SESSION['SESS_D_USER_EXAM']);
	if(x_count("exams_scores","script_owner='$user' LIMIT 1") > 0){
		?>
		<center><img src="img/chk.png" class="recheck" onclick="parent.location='recheck'" title="Please click here to check result(s) of courses taken" style="width:100%;margin-top:5px;"/></center>
		<?php
	}
}
// Result publishing Button Manager Ended
?>



</td>
</tr>

</table>
     	<script src="shutdown.js" type="text/javascript"></script>
     	<div id="logi"></div>
</div>

<div id="footer" class="d-none">
<?php include("footer.php");?>
</div>
</div>
</body>

</html>
