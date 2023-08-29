<!DOCTYPE html>
<html>
<head>
	<title>
	Result Slip For <?php echo $namm ;?>
	</title>
	<meta name="description" content="Result Slip For <?php echo $namm ;?>"/>
	<style>
	.print-rex{
		padding:17px;
		width:17px;
		height:20px;
		float:right;
	}
	
	body{
		background-image:url(img/washout.png);
		background-repeat:no-repeat;
		background-position:100%;
		background-size:cover;
	}
	.respage{
		border-bottom:2px solid black;
		border-left:2px solid black;
		border-right:2px solid black
		}
		
	.rechild{
		border-top:2px solid black;
		background-color:lightblue;
		background-image:url(img/bnner.png);
		margin-bottom:3pt;
		padding:10px;
		font-style:italic;
		text-transform:uppercase;
		letter-spacing:2px;
		font-size:10pt;
		font-family:Arial Narrow;
	}
</style>
</head>
<body>

<img class="print-rex" onclick="window.print()" title="Click this icon to print your result" src="image/print.png"/>

<center> <img src="img/ex3.png" style="width:40%"/></center>



<div style="margin:7pt">

<?php

	include("tabl.php");
	include("profile_score.php");

// modification started

	if(x_count("full_result_mode","id='1'") > 0){ // checking result mode
	
		$p = x_getsingleupdate("full_result_mode","status","id='1'");
		
		if($p == "enable"){
			
			?>
			
				<div class="respage">
				<h3 class="rechild">Full Result Details</h3>

				<table width="100%" border="1px" cellpadding="10px" cellspacing="0px">
				<tr>
				<td align='left' width='60%'><b>Total Questions</b></td>
				<td align='left' width='40%'><?php echo $qu_num." ";?></td>

				</tr>



				<tr>
				<td><b>Attempted</b></td>
				<td><?php echo "". $all_count."";?></td>


				</tr>


				<tr>
				<td><b>Failed</b></td>
				<td><?php $fa = $qu_num- $num; echo $fa." ";?></td>

				</tr>


				<tr>
				<td><b>Passed</b></td>
				<td><?php echo $num;?></td>

				</tr>

				<tr>
				<td><b>Total Score</b></td>
				<td><?php echo $num;?></td>

				</tr>

				<tr>
				<td><b>Percentage</b></td>
				<td><?php echo "". $m_percent."%";?></td>


				</tr>



				</table>
				</div>

			<?php
			
		}
		
	}
	
// modification ended
?>

</div>



</body>
</html>
