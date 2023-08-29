shortcut.add("Alt+4",function() {
	var answer = window.confirm("Are you sure you want to check your result now?");
	if(answer){
		window.location = "result_p";
		return true;
	}else{
		return false;
	}
});

shortcut.add("Alt+N",function() {
	forward();
});

shortcut.add("Alt+P",function() {
	backward();
});

shortcut.add("Alt+L",function() {
	var answer = window.confirm("Are you sure you want to logout?");
	if(answer){
		window.location = "logout";
		return true;
	}else{
		return false;
	}

});


shortcut.add("Alt+H",function() {
	$(document).ready(function(){
		$("#scor").slideUp("slow");
		$("#student_help").toggle("slow");
	});
});


shortcut.add("Alt+1",function() {
	$(document).ready(function(){
		$("#scor").slideUp("slow");
		$("#instru").toggle("slower");
		$(".exam_ins , .per_user , .exam_ass , .exam_pr").show("slower");
	});
});


shortcut.add("Alt+2",function() {
	$(document).ready(function(){
		$("#scor").slideUp("slow");
		$("#perso_pro").toggle("slow");
	});
});



shortcut.add("Alt+3",function() {
	$(document).ready(function(){
		$("#scor").slideUp("slow");
		$("#student_score").toggle("slow");
		$(".exam_ins , .per_user , .exam_ass , .exam_pr").show("slower");
	});
});

document.onkeydown = function (e) {
	
	        if(e.which == "65"){
			
					$(":radio.a").click();
					
	        }
			
	        if(e.which == "66"){
				
					$(":radio.b").click();
					
				}
				
			if(e.which == "67"){
				
					$(":radio.c").click();
				
				}
					
			if(e.which == "68"){
				
					$(":radio.d").click();
				
				}
				
			return true;
	}
	
	

				
				
function shu(){
	var answer = window.confirm("Are you sure you want to logout?");
	if(answer){
		window.location = "logout";
		return true;
	}else{
		return false;
	}
}


function forward(){
	var ips = document.getElementById("next").href;
	var  ty = document.getElementById("quest_type").value;
	var loc = "m_process?loc="+ips;
	
	if(ty == "subjective"){
		$("#datareader").attr("action",loc);
		$("#datareader").submit();
	}
	else{
		window.location = ips;
	}
}


function backward(){
	var ipp = document.getElementById("last").href;
	var ty = document.getElementById("quest_type").value;
	var loc = "m_process?loc="+ipp;
	
	if(ty == "subjective"){
		$("#datareader").attr("action",loc);
		$("#datareader").submit();
	}
	else{
		window.location = ipp;
	}
}


function openFullscreen(){
	  var elem = document.documentElement;
	  if (elem.requestFullscreen) {
		elem.requestFullscreen();
	  } else if (elem.webkitRequestFullscreen) { /* Safari */
		elem.webkitRequestFullscreen();
	  } else if (elem.msRequestFullscreen) { /* IE11 */
		elem.msRequestFullscreen();
	  }
}

				
function closeFullscreen() {
	  if (document.exitFullscreen) {
		document.exitFullscreen();
	  } else if (document.webkitExitFullscreen) { /* Safari */
		document.webkitExitFullscreen();
	  } else if (document.msExitFullscreen) { /* IE11 */
		document.msExitFullscreen();
	  }
}