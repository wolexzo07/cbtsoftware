function logout_computers(){
	var result = "#logi";
	//$(result).html("<center><img src='img/ajax-loader.gif' style='width:20px;'/></center>");
	$.ajax({
			url:"log_c",
			method:"GET",
			success:function(response){
				$(result).html(response);
			},
			error:function(){}
		});
}
 
function logc(){
    setInterval("logout_computers()" , 200);
}

logc();

/********
function logout_computers(){
var xmlhttp;
if(window.XMLHttpRequest){

xmlhttp = new XMLHttpRequest();

}
else{
xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

}
xmlhttp.onreadystatechange=function(){
if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

document.getElementById("logi").style.display="block";
document.getElementById("logi").innerHTML=xmlhttp.responseText;
document.getElementById("logi").style.border="0px";

}



}
var url = "log_c.php";

xmlhttp.open("GET",url ,true);
xmlhttp.send();

}
********/
