<?php include("validatingPage.php");?>
<form class="form-goto" action="pageit" method="POST">
	<p class="f-bold mb-1"><?php echo x_session("course_session");?></p>
	<select id="goto_rex" name="page" required="" onchange="gotopager()"></select>
	<input type="submit" id="goto_btn_click" class="d-none"/>	
</form>

<?php 
if(isset($_GET['pn'])){
	
	$cn = $_GET['pn'];
	
	}else{
		
	$cn = 1;
	
	}
	
	?>
<script>
	$(document).ready(function(){
		viewManager("#goto_rex","goto");
	});
	
	function gotopager(){
		$("#goto_btn_click").click();
	}
	
	function viewManager(result,cmd){
	  $(result).html("<center><img src='img/ajax-loader.gif' style='width:20px;'/></center>");
		$.ajax({
				url:"gotoController?pnum=<?php echo $cn;?>&cmd="+cmd,
				method:"GET",
				success:function(response){
					$(result).html(response);
				},
				error:function(){}
			});
	}
</script>