<style>
#incontent th {
	background-color:white; color:black;
}

#incontent td { border-bottom:1px dotted white; }
#incontent tr:hover{ background-color:white, color:black; }
</style>

<?php
	
	include "../lib/ProjectLibrary.php";
	$connection = new DatabaseConnection();
	if (($_POST['catname'] == 'All') && ($_POST['supname'] == 'All')){
		$query = "SELECT itemName, itemDescription, itemQuantity, itemPrice, itemDateLastAdded, itemStatus FROM item";
		$qresult = mysql_query($query);
	}
	else if(($_POST['catname'] == 'All') && ($_POST['supname'] != 'All')){
		$query = "SELECT SupplierID FROM supplier WHERE SupplierName = '".$_POST['supname']."'";
		$qresult = mysql_query($query);
		$result = mysql_fetch_array($qresult);
		$supID = $result['SupplierID'];
		$query = "SELECT itemName, itemDescription, itemQuantity, itemPrice, itemDateLastAdded, itemStatus FROM item WHERE supplierID = ".$supID."";
		$qresult = mysql_query($query);
	}
	else if(($_POST['supname'] == 'All') && ($_POST['catname'] != 'All')){
		$query = "SELECT categoryID FROM category WHERE categoryName = '".$_POST['catname']."'";
		$qresult = mysql_query($query);
		$result = mysql_fetch_array($qresult);
		$catID = $result['categoryID'];
		$query = "SELECT itemName, itemDescription, itemQuantity, itemPrice, itemDateLastAdded, itemStatus FROM item WHERE categoryID = ".$catID."";
		$qresult = mysql_query($query);
	}
	else{
		$query = "SELECT categoryID FROM category WHERE categoryName = '".$_POST['catname']."'";
		$qresult = mysql_query($query);
		$result = mysql_fetch_array($qresult);
		$catID = $result['categoryID'];
		$query = "SELECT SupplierID FROM supplier WHERE SupplierName = '".$_POST['supname']."'";
		$qresult = mysql_query($query);
		$result = mysql_fetch_array($qresult);
		$supID = $result['SupplierID'];
		$query = "SELECT itemName, itemDescription, itemQuantity, itemPrice, itemDateLastAdded, itemStatus FROM item WHERE categoryID = ".$catID." and supplierID = ".$supID."";
		$qresult = mysql_query($query);
	
	}
	
	$data = "<table style='width:100%' ><th>Name</th><th>Description</th><th>Quantity</th><th>Price</th><th>Data Last Updated</th><th>Status</th>";
	while($result = mysql_fetch_array($qresult)){
		$data = $data . "<tr><td>".$result['itemName']."</td><td>".$result['itemDescription']."</td><td>".$result['itemQuantity']."</td><td>".$result['itemPrice']."</td><td>".$result['itemDateLastAdded']."</td><td>".$result['itemStatus']."</td></tr>";
	}
	$data = $data . "</table>";
	echo $data;

?>