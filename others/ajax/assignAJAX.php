<?php
include "C:/wamp/www/SMSES/lib/ProjectLibrary.php";
session_start();

$connection = new DatabaseConnection();

if (isset($_GET['resign'])){
	
	$id = $_POST['cptrID'];
	$query = "UPDATE computer SET computerUser='' WHERE computerID=$id ";
	echo $query;
	mysql_query($query);
}
else if (isset($_GET['assign'])){
	
	$id = $_POST['cptrID']; $user = $_POST['id'];
	$query = "UPDATE computer SET computerUser='$user' WHERE computerID=$id ";
	mysql_query($query);
}
?>