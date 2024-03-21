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

function current_timer(){
	setInterval("timer_count()" , 200);
}

current_timer();