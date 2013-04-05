<?php
	$itemID = null; $item = null;
	
	if (isset($_GET['view'])){
		$itemID = $_GET['view'];
	}
	
	$connection = new DatabaseConnection();
	$item = new Item($itemID);
	
	$sup = new Supplier($item->getSupplier());

	//Getting the category
	$cat = "";
	$query = "SELECT categoryName FROM category WHERE categoryID=".$item->getCategory();
	$q = mysql_query($query);
	while($r = mysql_fetch_array($q)){
		$cat = $r['categoryName'];
	}
?>	
<div id='content-container' align='center'>
	<div id='content' align='left' class='rounded-corners'>
		<div id='content-title'>
			View Item Information
		</div>
		<div align='center'>
		<div id='item-viewer-information' align='center' style='width:80%;margin-top:2%;'>
			<table  cellspacing=1 width='100%'> <!-- style='width:100%;' -->
				<tr>
					<td> Item Code:  </td><td id='item-code' class='item'><?php echo $item->getID(); ?></td>
					<td> Item Name:  </td><td class='item'><?php echo $item->getName(); ?>&nbsp</td>
					<td> Item Description:  </td><td class='item'><?php echo $item->getDescription(); ?></td>
				</tr>
				<tr>
					<td> Item Category:  </td><td class='item'> <?php echo $cat; ?>&nbsp </td>
					<td> Item Supplier:  </td><td class='item'> <?php echo $sup->getName(); ?>&nbsp </td>
					<td> Item Status:  </td><td class='item'> <?php echo $item->getStatus(); ?></td>
				</tr>
			</table>
			<ul style='list-style:none'>
				<li><button id='edit-item-button'>Edit this Item</button></li>
		<?php
			if ($item->getStatus() == "GOOD"){
				echo "<li><button id='deactivate-item-button'> Deactivate this Item </button></li>";
			}
			else {
				echo "<li><button id='activate-item-button'> Activate this Item </button></li>";
			}
		
		?>
				<li><button id='back-to-inventory-button'> Back to Inventory Management </button></li>
			</ul>
			<br /><br />
		</div>
		</div>
		<div style='float:left; width:40%; margin-left:10%; margin-top:3%;'>
			<div id='content-sub-title'>
				Invoice Records
				<div>
				<table width='100%'>
					<th width='33%'>invoice number</th><th width='33%'>date</th><th width='33%'>quantity</th>
					<?php
						$query = "SELECT invoiceNumber, date, invoicequantity FROM invoice WHERE itemID = ".$item->getID()." ORDER BY invoiceNumber DESC LIMIT 0, 10";
						$query_result = mysql_query($query);
						while($result = mysql_fetch_array($query_result)){
							echo "<tr><td>".$result['invoiceNumber']."</td>";
							echo "<td>".$result['date']."</td>";
							echo "<td>".$result['invoicequantity']."</td></tr>";
						}
					?>
				</table>
				</div>
			</div>
			<div align='right' style='margin:1%;'><input type='button' id='show-all-invoices-button' value='Show All Invoices' class='button' /></div>
		</div>
		<div style='float:right; width:40%; margin-right:10%; margin-top:3%;'>
			<div id='content-sub-title'>
				Reciept Records
				<div>
				<table width='100%'>
					<th width='33%'>receipt number</th><th width='33%'>date</th><th width='33%'>quantity</th>
					<?php
						$query = "SELECT receiptNumber, date, quantity FROM receipt WHERE ItemID = ".$item->getID()." ORDER BY receiptNumber DESC LIMIT 0, 10";
						$query_result = mysql_query($query);
						while($result = mysql_fetch_array($query_result)){
							echo "<tr><td>".$result['receiptNumber']."</td>";
							echo "<td>".$result['date']."</td>";
							echo "<td>".$result['quantity']."</td></tr>";
						}
					?>
				</table>
				</div>
			</div>
			<div align='right' style='margin:1%;'><input type='button' id='show-all-receipts-button' value='Show All Receipts' class='button' /></div>
		</div>
	</div>
</div>

<!-- jQuery Dialogs -->
<div id='confirm-deactivate-dialog' class='dialog-content' title='Confirm Deactivate Item' >
	<p>
		Are you sure do you want to deactivate this item?
		<i> This assumes that the inventory manager has cleared all necessary duties for
			deactivation of the item. </i>
	</p>
</div>

<div id='confirm-activate-dialog' class='dialog-content' title='Confirm Activate Item' >
	<p>
		Are you sure do you want to activate this item?
		<i> This assumes that the inventory manager has cleared all necessary duties for
			activation of the item. </i>
	</p>
</div>

<div id='edit-item-dialog' class='dialog-content' title='Edit Current item information'>
	<?php
		$utility = new Utility;
		$utility->spawn_loading_image('loading-edit-item');
	?>
</div>

<div id='show-all-invoices-dialog' class='dialog-content' title='showing all invoices...'>
	<table>
		<th>invoice number</th><th>date</th><th>quantity</th>
			<?php
				$query = "SELECT invoiceNumber, date, invoicequantity FROM invoice WHERE itemID = ".$item->getID()." ORDER BY invoiceNumber DESC LIMIT 0, 10";
					$query_result = mysql_query($query);
					while($result = mysql_fetch_array($query_result)){
						echo "<tr><td>".$result['invoiceNumber']."</td>";
						echo "<td>".$result['date']."</td>";
						echo "<td>".$result['invoicequantity']."</td></tr>";
					}
			?>
	</table>
</div>

<div id='show-all-receipts-dialog' class='dialog-content' title='showing all recepits...'>
	<table>
		<th>receipt number</th><th>date</th><th>quantity</th>
			<?php
				$query = "SELECT receiptNumber, date, quantity FROM receipt WHERE ItemID = ".$item->getID()." ORDER BY receiptNumber DESC LIMIT 0, 10";
					$query_result = mysql_query($query);
						while($result = mysql_fetch_array($query_result)){
							echo "<tr><td>".$result['receiptNumber']."</td>";
							echo "<td>".$result['date']."</td>";
							echo "<td>".$result['quantity']."</td></tr>";
						}
			?>
	</table>
</div>
<!-- End jQuery Dialog -->