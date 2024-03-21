function result(str){
	var result = "#search";
	
	// getting parameters on the page 
	
	var id = $("#id").val();
	var tok = $("#tok").val();
	var typet = $("#typet").val();
	var subjec = $("#subjec").val();
	var emailed = $("#emailed").val();
	
	var vurl = "submitajax?opt=" + str + "&id=" + id + "&tokken=" + tok + "&subject=" + subjec + "&typing=" + typet+ "&emailer=" + emailed;
	
	$.ajax({
			url:vurl,
			method:"GET",
			success:function(response){
				$(result).html(response);
			},
			error:function(){}
		});
}

