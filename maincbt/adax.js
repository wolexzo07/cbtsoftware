/****

function timer_count(){
	var result = "#timeclasse";
	$.ajax({
			url:"count",
			method:"GET",
			success:function(response){
				$(result).html(response);
			},
			error:function(){}
		});
}

****/
