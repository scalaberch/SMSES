<?php
	include_once "../lib/ProjectLibrary.php";
	$connection = new DatabaseConnection();
?>

<div id='cont-table'>
<?php
	//$end = $index + 10;
/*
	if($_GET['searchtype'] == 'name'){
	$query = "SELECT itemID, itemName, itemDescription, itemQuantity, categoryID FROM item WHERE itemName='".$_GET['search']."'";
	}
	else{
	$query = "SELECT itemID, itemName, itemDescription, itemQuantity, categoryID FROM item WHERE itemDescription='".$_GET['search']."'";
	}
*/	
/*
	$query = "SELECT itemID, itemName, itemDescription, itemQuantity, categoryID FROM item WHERE itemID=".$_GET['search']."";
	$query_result = mysql_query($query);
	if($result = mysql_fetch_array($query_result)){
	echo "<table cellspacing=5 id='table-content' id='".$result['itemID']."'class='table-field'>";
	echo "<tr><td><b>Item Name: </b></td><td>".$result['itemName']."</td></tr>";
	echo "<tr><td><b>Item Description: </b></td><td>".$result['itemDescription']."</td></tr>";
	echo "<tr><td><b>Quantity: </b></td><td>".$result['itemQuantity']."</td></tr>";
	$cat = "SELECT categoryName FROM category WHERE categoryID = ".$result['categoryID']."";
	$query_cat = mysql_query($cat);
	$catname = mysql_fetch_array($query_cat);
	echo "<tr><td><b>category: </b></td><td>".$catname['categoryName']."</td></tr>";
	echo "</table>";
	}
	else{
	echo "
	<div class='ui-state-error ui-corner-all'>
	no item matched
	</div>
	";
	} */
	
	//if naka set to siya... mao ni iyang himuon...
	$item = new Item($_GET['search']);
	//for category... kalimot man ko
	$query = "SELECT itemID, itemName, itemDescription, itemQuantity, categoryID FROM item WHERE itemID=".$_GET['search']."";
	$query_result = mysql_query($query);
	$result = mysql_fetch_array($query_result);
	
	$cat = "SELECT * FROM category WHERE categoryID = ".$result['categoryID']."";
	$query_cat = mysql_query($cat);
	$catname = mysql_fetch_array($query_cat);
	//for supplier
	$supplier = new Supplier($item->getSupplier());
	//for item entry
	$quan = "SELECT itemQuantity FROM item WHERE itemID = ".$_GET['search']."";
	$query_quan = mysql_query($quan);
	$quanname = mysql_fetch_array($query_quan);
?>
<div id='table-content'>
	<table cellspacing=0 >
		<tr>
			<td class='title'>Item Code</td><td><?php echo $item->getID(); ?></td>
			<td class='title'>Item Name</td><td colspan=3><?php echo $item->getName(); ?></td>
		</tr>
		<tr>
			<td class='title'>Item Description</td><td colspan=5 ><?php echo $item->getDescription(); ?></td>
		</tr>
		<tr>
			<td class='title'>Item Category</td><td><?php echo $catname['categoryName']; ?></td>
			<td class='title'>Supplier Name</td><td colspan=3 ><?php echo $supplier->getName() ?></td>
		</tr>
		<tr>
			<td class='title'>Item Location</td><td><?php echo $catname['categoryLocation']; ?></td>
			<td class='title'>Supplier Address</td><td colspan=3 ><?php echo $supplier->getAddress(); ?></td>
		</tr>
		<tr>
			<td class='title'>Item Price</td><td><?php echo $item->getPrice(); ?></td>
			<td class='title'>Items Available</td><td><?php echo $quanname['itemQuantity']; ?></td>
			<td class='title'>Item STATUS</td><td><?php echo $item->getStatus(); ?></td>
		</tr>
	</table>
</div>
</div>