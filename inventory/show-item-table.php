<?php
	include_once "../lib/ProjectLibrary.php";
	$connection = new DatabaseConnection();
	$index = $_GET['location'] - 1; $total = 0; $count = 0;
	
	$query_result = mysql_query("SELECT COUNT(1) as 'Total' FROM item");
	while($result = mysql_fetch_array($query_result)){
		$total =  $result['Total'];
	}
	
?>
<script type='text/javascript'>
	$(".table-field")
		.click(function () {
			var id = $(this).attr("id");
			
			$('#content').hide(500);
			var location = "?inventory&view="+id;
			window.open(location, '_self');
		});
</script>
<div id='cont-table'>
<div id='content-table-nav'>
<?php
	//echo $index;
	$prev_loc = $_GET['location'] - 10;
	if ($index != 0){
		echo "<a href='Javascript:add_table_content(".$prev_loc.")'> Previous </a>";
	}
	else {
		echo "Previous";
	}
?> |
<?php
	$next_loc = $_GET['location']+10;
	if ($next_loc < $total){
		echo " <a href='Javascript:add_table_content($next_loc)'> Next </a>";
	}
	else {
		echo "Next";
	}


?>


</div>
<table cellspacing=0 id='table-content'>
	<th> Item Code </th><th>Item Name </th>
	<th> Item Description</th><th> Item Quantity </th><th> Item Category </th>
<?php
	$end = $index + 10;
	$query = "SELECT itemID, itemName, itemDescription, itemQuantity, categoryID FROM item LIMIT $index, $end";
	$query_result = mysql_query($query);
	while($result = mysql_fetch_array($query_result)){
		$count++;
		echo "<tr id='".$result['itemID']."'class='table-field'>";
		echo "<td>".$result['itemID']."</td>";
		echo "<td>".$result['itemName']."</td>";
		echo "<td>".$result['itemDescription']."</td>";
		echo "<td>".$result['itemQuantity']."</td>";
		$cat = "SELECT categoryName FROM category WHERE categoryID = ".$result['categoryID']."";
		$query_cat = mysql_query($cat);
		$catname = mysql_fetch_array($query_cat);
		echo "<td>".$catname['categoryName']."</td>";
		echo "</tr>";
	}
	
	echo "</table>
			<div id='table-info'>
				Showing $count item(s) in total of $total items.</div>";
?>
</div>