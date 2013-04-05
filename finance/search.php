<script type='text/javascript'>
	$(function() {
		$('#content-container').show('drop', 1000);
		
		$('#cancel-transaction-holder').hide(0);
		
		//Reset all transactions..
		$.ajax({ url:"utility.php?cancelReceipt", datatype: "html" });
		
		//Autocomplete Items...
		
		//Dialogs
		$('#show-new-transaction-dialog-warning').dialog({
			autoOpen:false, modal:true,
			buttons: {
				OK: function () { $(this).dialog("close"); }
			}
		});
		
		$('#search-item-dialog')
			.dialog({
				autoOpen:false, modal:true, width:460,
				show:"fold", hide:"fold", resizable:false
			});
		
		/* Buttons and Other Objects */
		$('#recieve-payment-button').button({icons:{primary:"ui-icon-cart"}});
		$('#cancel-transaction-button')
			.button({icons:{primary:"ui-icon-closethick"}})
			.click(function () {
				$.ajax({
					url:"utility.php?cancelReceipt",
					datatype: "html",
					success: function (data) {
						$('#new-transaction-holder').show(0);
						$('#cancel-transaction-holder').hide(0);
						$('#recieve-payment-button').attr("disabled", "disabled");
						$('#recieve-payment-button').button("refresh");
						
					}
				});
			});
		$('#new-transaction-button')
			.button({icons:{primary:"ui-icon-closethick"}})
			.click( function () {				
				//Invoke AJAX for New Reciept Data Struct
				$.ajax({
					url:"utility.php?setNewReceipt",
					datatype: "html",
					success: function (data) {
						//Edit Eye-Candy
						$('#new-transaction-holder').hide(0);
						$('#cancel-transaction-holder').show(0);
						$('#recieve-payment-button').removeAttr("disabled");
						$('#recieve-payment-button').button("refresh");
						
						//Empty all table information
						var table_head = "<tr><th>Item Code</th><th>Unit Price</th><th>Quantity</th><th>Amount</th></tr>";
						$('#queue-table-content').html(table_head);
					}
				});
			});
		$('#back-button').button({icons:{primary:"ui-icon-home"}})
			.click(function () {
				$.ajax({
					url:"utility.php?hasTransaction",
					datatype: "html",
					success: function (data) {
						if (data == "true"){
							//Fix: use jQuery Dialog
							var sure = confirm("There are still a transaction going on.\nQuitting this form will clear this transaction. \n Press OK to continue quitting, otherwise press Cancel.");
							if (sure){
								$.ajax({
									url:"utility.php?cancelReceipt",
									datatype: "html",
									success: function (data) {
										window.open("?", "_self");
									}
								});
							}
						}
						else {
							window.open("?", "_self");
						}
					}
				});
			});;
		
		$('#item-code, #item-quantity, #add-to-queue, #search-item-button')
			.attr("disabled", "disabled");
			
		$('#recieve-payment-button').attr("disabled", "disabled");
		$('#recieve-payment-button').button("refresh");
		
		$('#usage, #usage2')
			.change( function () {
				var balyu = $(this).val();
				if (balyu == "barcode"){
					//disable that one...
					$('#item-code, #item-quantity, #add-to-queue, #search-item-button')
						.attr("disabled", "disabled");
					$('#add-to-queue, #search-item-button')
						.button("refresh");
				}
				else {
					//enable...
					$('#item-code, #item-quantity, #add-to-queue, #search-item-button')
						.removeAttr("disabled");
					$('#add-to-queue, #search-item-button')
						.button("refresh");
				}
			});
	});
	
	function add_item_to_queue() {
		$.ajax({
			url:"utility.php?hasTransaction",
			datatype: "html",
			success: function (data) {
				if (data == "true"){
					var item_code = $('#item-code').val(),
						quantity = $('#item-quantity').val();
					
					//Pilitize it into the Item Description...
					//not yet; change_item_view_description(item_code, "fdsf", "ppp", "Php.");
					
					//Call AJAX to check if it is in DB
					$.ajax({
						url:"utility.php?checkIfItemisInDB",
						type: "POST",
						datatype: "html",
						data: {
							item: item_code
						},
						success: function (data) {
							if (data == "true")
							{
								if (quantity == 0 || quantity == ""){
									alert("Please enter a quantity.");
								}
								else {
									var location = "utility.php?getItemInfo&item="+item_code;
									//Get the price, name, and description...
									$.getJSON(location, function(json){
										//Calculate price...
										var total_price = json.price * quantity;
										//Append to SESSION holder
										
										//Replace item information...
										$('#viewer-item-id').html(item_code);
										$('#viewer-item-name').html(json.name);
										$('#viewer-item-description').html(json.description);
										$('#viewer-item-price').html("Php. " + json.price);
										
										
										//Append to table...
										var line = "<tr><td>"+item_code+"</td><td> Php. "+json.price+"</td><td>"+quantity+"</td><td>Php. "+total_price+"</td></tr>";
										$('#queue-table-content tr:last').after(line);
										
									});	
								}
							}
							else {
								alert("Item is not in the database. Please check your Item ID");
							}
						}
					});
				}
				else {
					$('#show-new-transaction-dialog-warning').dialog("open");
				}
			}
		});
	}
	
	function change_item_view_description(itemCode, itemName, itemDescription, itemPrice){
		$('#viewer-item-id').html(itemCode);
		$('#viewer-item-name').html(itemCode);
		$('#viewer-item-description').html(itemCode);
	}
	
	function open_search_dialog() { $('#search-item-dialog').dialog("open"); }
	
</script>
<div id='content-container' align='center'>
	<div id='content' align='left' class='rounded-corners'>
		<div id='content-title'>
			Cash Drawer
		</div>
		<div id='content-menu-buttons'>
			<a href='?'>Back to Inventory Menu&nbsp </a>
		</div>
		
		<div id='cash-drawer-container'>
			<div id='purchase-queue-container' >
				<div id='content-sub-title'>
				Purchase Queue
				</div>
				<div id='add-queue-container'>
					<div style='margin-left:6%;'><form>
						<input type='radio' name='usage' value='barcode' id='usage' /> Use Barcode Reader
						<input type='radio' name='usage' value='manual' id='usage2' /> Enter Manually
					</form></div>
					<ul>
						<li>Item Code: <input type='text' id='item-code' /></li>
						<li>Quantity: <input type='text' id='item-quantity' size=1 /></li>
						<li>
							<a href='Javascript:add_item_to_queue()' id='add-to-queue' class='button'>
								<span class="ui-icon ui-icon-plusthick"></span>
							</a>
						</li>
						<li>
							<a href='Javascript:open_search_dialog()' id='search-item-button' class='button'>
								<span class="ui-icon ui-icon-search"></span>
							</a>
						</li>
					</ul>
				</div>
				<div id='queue-table'>
				<table id='queue-table-content' style='width:100%' cellspacing=0>
					<th>Item Code</th><th>Unit Price</th><th>Quantity</th><th>Amount</th>
					<!-- recurse fetching data from db here 
					<tr><td>1234</td><td>3400</td><td>4</td><td>20000</td></tr>
					-->
					<tr></tr>
					
				</table>
				</div>
			</div>
		<div id='purchase-navigation-container'>
			<div id='queue-item-description' style='height:35%;'>
				<div id='content-sub-title'>Item Description</div>
				<b>Item ID:</b> <span id='viewer-item-id'></span><br />
				<b>Item Name: </b><span id='viewer-item-name'></span><br />
				<b>Item Description:</b><span id='viewer-item-description'></span><br />
				<b>Unit Price:</b><span id='viewer-item-price'></span>
			</div>
			<div id='purchase-navigation'>
				<div id='content-sub-title'>Cash Drawer Navigation</div>
				<div id='total-purchase'>
					Total Amount:
					<span id='total-amount' style='float:right'>
						Php. 0.00
					</span>
				</div>
				<ul id='purchase-buttons'>
					<li><input type='button' id='recieve-payment-button' style='width:100%' value='Recieve Payment' /></li>
					<li id='new-transaction-holder'>
						<input type='button' id='new-transaction-button' class='button' style='width:100%' value='New Transaction'>	
					</li>
					<li id='cancel-transaction-holder'>
						<input type='button' id='cancel-transaction-button' class='button' style='width:100%' value='Cancel Transaction'>	
					</li>
					<li>
						<a href='#' id='back-button' class='button' style='width:100%'>
							Back to Financial Menu
						</a>
					</li>
					
				</ul>
			</div>
		</div>
		</div>
	</div>
</div>

<!-- jQuery Dialogs -->
<div id='show-new-transaction-dialog-warning' title='No Transaction Initiated'>
	Please click the "New Transaction" button to start.
</div>
<div id='search-item-dialog' class='dialog-content' title='Search for an Item' >
	<div style='border-bottom:1px dotted white;padding-bottom:3px;'>
		Enter item name here:
		<input type='text' id='search-item-field'/>
		<input type='button' id='check-item-button' class='button' value='Check Item Information' />
	</div>
	<div style='margin-top:10px' id='item-search-table' style=''>
		<table>
			<th>Item ID</th><th>Item Name</th><th>Item Description</th>
			<tr>
				<td id='search-item-field-id'>88329</td><td id='search-item-field-name'></td>
				<td id='search-item-field-description'></td>
			</tr>
		</table>
		<div align='right'>
			<input type='button' id='view-selected-item-button' class='button' disabled='disabled' value='Add this Item' />
		</div>
	</div>
</div>
<!-- End jQuery Dialog -->