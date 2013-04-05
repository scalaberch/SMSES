<script type='text/javascript'>
	$(function() {
		var current_page = 1;
		$('#error-message-manager-inventory').hide(0);
		
		$('#search-item-dialog')
			.dialog({
				autoOpen:false, modal:true, width:460,
				show:"fold", hide:"fold", resizable:false
			});
			
		$('#item-information-dialog')
			.dialog({
				autoOpen:false, modal:true, width:460,
				show:"fold", hide:"fold", resizable:false
			});
			
		$('#search-item-field')
			.autocomplete({
				source: "getitems.php?inventory",
				minLength: 3
			}
		);
		
		$('#check-item-button')
			.button()
			.click( function () { 
				append_search_result(); 
				$('#view-selected-item-button').removeAttr('disabled');
				$('#view-selected-item-button').button('refresh');
		});
		
		$('#view-selected-item-button')
			.click( function () {
				var item = $('#search-item-field-id').html();
				var location = "?inventory&view="+item;
				window.open(location, '_self');
				
			});
		
		//Item Viewer Buttons...
		$('#edit-item-button')
			.button({ icons: { primary: "ui-icon-wrench" } })
			.click( function () {
				$('#edit-item-dialog').dialog('open');
				//Get AJAX entry for the edit item box...
				var item_id = $('#item-code').html();
				$.ajax({
					url:"item-form.php",
					datatype:"html",
					type:"POST",
					data: {
						itemID:item_id
					},
					success: function(data1){
						setTimeout( function () {
							$('#loading-edit-item').hide('fade', 500);
							//$('#loading-edit-item').remove();
						}, 500);
						setTimeout( function () {
							$('#item-form').remove();
							$('#edit-item-dialog').append(data1).fadeIn(1000);
						}, 1000);
					}
		
				});
			});
			
		$('#deactivate-item-button')
			.button({ icons: { primary: "ui-icon-cancel" } })
			.click( function () {
				$('#confirm-deactivate-dialog').dialog('open');
			});
			
		$('#activate-item-button')
			.button({ icons: { primary: "ui-icon-check" } })
			.click( function () {
				$('#confirm-activate-dialog').dialog('open');
			});
			
		$('#back-to-inventory-button')
			.button({ icons: { primary: "ui-icon-circle-arrow-w" } })
			.click( function () {
				//Fix: Insert Animation here
				window.open('?inventory', '_self');
			});
			
		//Item Viewer Dialogs
		$('#confirm-deactivate-dialog')
			.dialog({
				autoOpen:false, modal:true, resizable:false, show:"fold", hide:"fold",
				buttons: {
					Yes: function () {
						var id = $('#item-code').html();
						
						$.ajax({
							url:"activate.php?deactivate",
							type:"POST",
							datatype: "html",
							data: {
								itemID:id
							},
							success: function (data) {
								//alert(data);
								var loc = "?inventory&view="+id;
									window.open(loc, '_self');
								
								if (data == "true"){
									//Show OK Message
									
								}
								else {
									//Show Error Message
								}
							}
						});
						//$(this).dialog('close');
					},
					No: function () { $(this).dialog('close'); }
				}
			});
			
		$('#confirm-activate-dialog')
			.dialog({
				autoOpen:false, modal:true, resizable:false, show:"fold", hide:"fold",
				buttons: {
					Yes: function () {
						var id = $('#item-code').html();
						
						$.ajax({
							url:"activate.php?activate",
							type:"POST",
							datatype: "html",
							data: {
								itemID:id
							},
							success: function (data) {
								//alert(data);
								var loc = "?inventory&view="+id;
									window.open(loc, '_self');
								if (data == "true"){
									//Show OK Message
									var loc = "?inventory&view="+id;
									window.open(loc, '_self');
								}
								else {
									//Show Error Message
								}
							}
						});
					
						//$(this).dialog('close');
					},
					No: function () { $(this).dialog('close'); }
				}
			});
		
		$('#edit-item-dialog')
			.dialog(
				{ 
					autoOpen:false, modal:true, resizable:false, show:"fold", hide:"fold",
					width:520
				}
			);
			
		//Item-Viewer JS
		$('#show-all-invoices-button').button()
			.click(function(){
				$('#show-all-invoices-dialog').dialog("open");
			});
			
		$('#show-all-invoices-dialog').dialog(
			{
				autoOpen:false, modal:true,
				button: {
					"Done": function () {
						$(this).dialog("close");
					}
				}
			}
		);
		
		$('#show-all-receipts-button').button()
			.click(function(){
				$('#show-all-receipts-dialog').dialog("open");
			});
			
		$('#show-all-receipts-dialog').dialog(
			{
				autoOpen:false, modal:true,
				button: {
					"Done": function () {
						$(this).dialog("close");
					}
				}
			}
		);
		
		//Initialization of informatioin in inventory/?inventory
		add_table_content(current_page);
	
	});
	
	function get_itemID_in_screen() {
		return $('#item-code').val();
	}
	
	function open_search_item_dialog(){ $('#search-item-dialog').dialog('open'); }
	function open_add_item_dialog(){
		$('#item-information-dialog').dialog('open');
		//$('#item-information-dialog').attr('title', 'Add Item to the Inventory');
		$.ajax({
			url:"additem.php",
			datatype:"html",
			success: function(data1){
				$('#loading').hide('fade', 500);
				$('#add-item-form').remove();
				$('#item-information-dialog').append(data1);
			}
		
		});
		//setTimeout(function () {$('#loading').hide(0);}, 2000);
	}
	
	function add_table_content(page){
		var loading = "<div id='loading-table' align='center'><img src='../lib/img/load.gif' style='margin-top:40px' /></div>";
		$('#content-table').hide(500);
		$('#cont-table').remove();
		$('#content-table').html(loading);
		$('#content-table').show(500);
		$.ajax({
			url:"show-item-table.php",
			datatype:"html",
			type:"GET",
			data:{
				location:page
			},
			success: function(data){
				$('#loading-table').hide('fade', 500);
				$('#content-table').html("");
				setTimeout(function () {
					$('#content-table').append(data).fadeIn(1000);
				}, 700);
			}
		
		});
	}
	
	function append_search_result(){
		
		var search_result = $('#search-item-field').val(),
			location = "get_item_details.php?fromItemName="+search_result;
			
		//check muna if item is in DB...
		$.ajax({
			url:"ajax/additem.php?isInDB",
			datatype: "html", type:"POST",
			data: {
				search: search_result
			},
			success: function (data) {
				if (data == "true"){
					$.getJSON(location, function(json){
						$('#search-item-field-id').html(json.id); 
						$('#search-item-field-name').html(json.name);
						$('#search-item-field-description').html(json.description); 
					});	
				}
				else {
					$('#error-message-manager-inventory').show('fade', 500);
					setTimeout( function () {
						$('#error-message-manager-inventory').hide('fade', 500);
					}, 3000);
				}
			}
		});

		
	}
	
</script>
<?php
	if (isset($_GET['view'])){
		include "item-viewer.php";
	}
	else if (isset($_GET['add'])){
		include "additem.php";
	}
	else {
		include "inventory-manager.php";
	}

?>
