<?php
include "C:/wamp/www/SMSES/lib/ProjectLibrary.php";
session_start();

$connection = new DatabaseConnection();

	
	$myip = getenv("REMOTE_ADDR");
	$query = "SELECT * FROM computer WHERE computerIPAddress='$myip'";
	$query_result = mysql_query($query);
	while($result = mysql_fetch_array($query_result)){
		echo $result['computerName'];
	}
	
	$query = "UPDATE computer SET computerUser='$user' WHERE computerIPAddress='$myip' ";
	mysql_query($query);


?>