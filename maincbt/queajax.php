<div id="q">
<p style="margin-bottom:10pt;">
	<font style="color:gray;font-size:11pt;letter-spacing:2px;display:;"><?php echo "Course &raquo; ". "<i>".$cat."</i>";?>
	<?php echo "&nbsp;&nbsp;|&nbsp;&nbsp;Type &raquo; ". "<i>".$qtype."</i>";?>&nbsp;&nbsp;|&nbsp;&nbsp;Total Question &raquo; <?php echo $nr; ?>
	</font>
</p>

<?php
	$allowed = array("objective","subjective");
	
	if(in_array($qtype , $allowed)){
		
		if($qtype == "objective"){
		
			include("objectives.php");
		
	    }
		
		if($qtype == "subjective"){
			
			include("m_ext.php");
			
		}
		
	}else{
		
		echo "No paper type!";
		
	}
	
?>
</div>
