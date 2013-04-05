<div id='sub-menu' align='center'>
		<div id='menu' align='left'>
<script type='text/javascript'>
	$.ajax({ url:"sessionteller.php?position", datatype: "html",
		success: function (data) {
			if (data == 'Attendant'){
				$('#inventory-manage-inventory').remove();
			}
			else{
				$('#inventory-search-item').remove();
			}
		}
	});
</script>
			<ul>
				<li id='inventory-search-item'>
					<img src='../lib/img/small/search.png' style='float:left;margin-right:8px;'/>
					Search for an Item 
				</li>
				<li id='inventory-manage-inventory'>
					<img src='../lib/img/small/manage-inventory.png' style='float:left;margin-right:8px;'/>
					Manage Inventory 
				</li>
	<!--
				<li id='inventory-manage-suppliers'>
					<img src='../lib/img/small/supplier.png' style='float:left;margin-right:8px;'/>
					Manage Suppliers
				</li>
	-->
				<li id='inventory-back'> 
					<img src='../lib/img/small/back.png' style='float:left;margin-right:8px;'/>
					Go back to Dashboard
				</li>
			</ul>
		</div>
		<div id='sub-menu-text' align='left'>
			<img src='../lib/img/icon/inv.png' style='float:left'/>
				<div class='sub-menu-text-main'>
					inventory
				</div>
				inventory management sub-menu				
		</div>
	</div>