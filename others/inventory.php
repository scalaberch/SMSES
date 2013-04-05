<script type='text/javascript'>
	$(function() {
		$('#search-item-dialog')
			.dialog({
				autoOpen:false, modal:true,
				show:"fold", hide:"fold"
			});
	});
	
	function open_search_item_dialog(){ $('#search-item-dialog').dialog('open'); }
	
</script>
<div id='content-container' align='center'>
	<div id='content' align='left' class='rounded-corners'>
		<div id='content-title'>
			Generate Inventory Reports
		</div>
		<div id='content-menu-buttons'>
			<ul class='ui-widget ui-helper-clearfix'>

				<li><a href='?'>Back to Reports Menu&nbsp </a></li>
				<!--
				<li>
					<a href='?' class='button'>
						<span class="ui-icon ui-icon-circle-triangle-w"></span>
					</a>
				</li>
				-->
			</ul>
		</div>
		
		
		<div id='content-table'>
		
		</div>
	</div>
</div>

<!-- jQuery Dialogs -->
<div id='search-item-dialog' class='dialog-content' title='Search for an Item' >
	<div style='border-bottom:1px dotted white;padding-bottom:3px;'>
		Enter item name here:
		<input type='text' />
		<input type='button' id='check-item-button' class='button' value='Check Item Information' />
	</div>
	<div>
	
	
	</div>
</div>
<!-- End jQuery Dialog -->