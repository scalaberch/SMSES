<?php
session_start();

if(isset($_GET['position'])){
	echo $_SESSION['position'];
}


?>