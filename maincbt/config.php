<?php
/*
Database connection script developed by Biobaku Oluwole Timothy under the distribution licence of xelow global concept
*/
$con = mysqli_connect("localhost" ,"root" ,"follower1990","cbtsoftware") or die("Error connecting...".mysqli_connect_error());

function clean($chk){
	return x_clean($chk);
}
?>