<?php
	include "../lib/ProjectLibrary.php";
	
	$connection = new DatabaseConnection();
	$category = new Category(); $supplier = new Supplier(112);
	
	$id = $_POST['itemID'];
	$item = new Item($id);
?>
<div id='item-form'>
<script type='text/javascript'>
	//Edit Item Dialog Buttons 
		$('#execute-edit-item-information-button')
			.button()
			.click( function () {
				//Fix: Execute Edit Item Information 
				var category = $('#category-list').val(),
					supplier = $('#supplier-list').val(),
					itemCode = $('#edit-item-code').val(),
					itemName = $('#edit-item-name').val(),
					itemDescription = $('#edit-item-description').val();
				
					$.ajax({
						url:"ajax/edititem.php?edit",
						datatype: "html", type:"POST",
						data: {
							id:itemCode, name:itemName, desc:itemDescription,
							supp:supplier, cat:category
						},
						success: function(){
							var loc = '?inventory&view='+itemCode;
							$("#edit-item-dialog").dialog("close");
							//
							//alert(loc);
							window.open(loc, '_self');
						}
					});
				});
			
		$('#exit-edit-item-information-button')
			.button()
			.click( function () {
				$("#edit-item-dialog").dialog("close");
			});
			
		var boom = "<?php echo $item->getID(); ?>";
		//alert(boom);
	
</script>
<!-- TODO: Get isset() functions on the move... -->
Item Code : 
	<span style='margin-right:5%;'>
		<!-- SPACER --> &nbsp 
	</span>
<input type='text' id='edit-item-code' disabled='disabled' value='<?php echo $item->getID(); ?>' />
Item Name: <input type='text' id='edit-item-name' value='<?php echo $item->getName(); ?>' style='width:38%' /><br />
Item Description: <input type='text' id='edit-item-description' value='<?php echo $item->getDescription(); ?>' style='width:80%' /><br />
Category: 
	<?php $category->print_all_category(); ?>		
Supplier:
	<?php $supplier->print_all_suppliers(); ?>
	
<div id='edit-item-dialog-buttons' style='float:right; margin-top:1%;'>
	<input type='button' id='execute-edit-item-information-button' value='Edit Item Information' />
	<input type='button' id='exit-edit-item-information-button' value='Cancel' />
</div>
</div>
<?php
	mysql_close($connection->connection);
?>	