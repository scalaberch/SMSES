<!--
<script src="jquery-1.7.1.js"></script>
<script src="ui/jquery.ui.core.js"></script>
<script src="ui/jquery.ui.widget.js"></script>
<script src="ui/jquery.ui.position.js"></script>
<script src="ui/jquery.ui.autocomplete.js"></script>
-->
<style>
	.ui-autocomplete {
		max-height: 200px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		/* add padding to account for vertical scrollbar */
		padding-right: 20px;
	}
	/* IE 6 doesn't support max-height
	 * we use height instead, but this forces the menu to always be this tall
	 */
	* html .ui-autocomplete {
		height: 200px;
	}
	</style>
<script type='text/javascript'>
	$(function() {
		
		$('#search-field').autocomplete({
			source: "ajax/search.php",
			minLength:1,
			select: function (event, ui){
				//alert(ui.item.value);
				//alert(ui.item.name);
				//alert(ui.item.desc);
				$('#search-field').val(ui.item.value);
				$('#search-key').val(ui.item.id);
				//alert($('#search-key').val());
			},
			focus: function (event, ui) {
				$('#search-field').val(ui.item.value);
			}
		})
		.data("autocomplete")._renderItem = function( ul, item ) {
			return $("<li></li")
						.data("item.autocomplete", item)
						.append("<a><b>" + item.value + "</b><br>" + item.desc + "</a>")
						.appendTo(ul);
		};
		
		//Search Type function
		$('#search-type').change( function () {
			var value = $(this).val();
			$.ajax({
				url:"ajax/search.php?set",
				datatype:"html", type:"POST",
				data: {
					setting:value
				}
			});
			//alert(value);
		});
		$('#search-button')
			.click( function () {
				var search = "<div id='loading-image'><img src='../lib/img/load.gif' /></div>";
				var search_key = $('#search-key').val();
				var search_field = $('#toSearch').val();
				
				$('#search-result').html("");
				$('#search-result').append(search);
				if (search_key == "" || search_field == "search"){
					setTimeout(function () {
						$('#loading-image').remove();
						$('#search-result').append("<div id='error-message' class='ui-state-highlight ui-corner-all' style='padding:5px 0px 5px 0px'>Please enter a search keyword.</div>");
						setTimeout(function () {
							$('#error-message').remove().fadeOut(1000);
						}, 3000);
					}, 1000);
				}
				else {
					$.ajax({
					url:"searchresult.php",
					datatype:"html",
					type:"GET",
					data:{
						search:search_key
					},
					success: function(data){
						$('#loading-image').remove();
						setTimeout(function () {
							$('#search-result').append(data).fadeIn(1000);
							$('#search-key').val("");
						}, 700);
					}
		
					});
				}
			}
		);
		
		//Initiator
		$.ajax({
			url:"ajax/search.php?set",
			datatype:"html", type:"POST",
			data: {
				setting:"name"
			}
		});
	});
</script>
<div id='content-container' align='center'>
	<div id='content' align='left' class='rounded-corners'>
		<div id='content-title'>
			Search for an Item Information
		</div>
		<div id='content-menu-buttons'>
			<a href='?'>Back to Inventory Menu&nbsp </a>
		</div>
		<div id='search-form' style='width:100%;margin-top:3%; border-bottom:1px dotted white;'>
			<table style='bottom-border:1px dotted white;'>
			<tr><td style='width:8%'>Search by:</td>
			<td style='width:12%'><select id='search-type' >
				<option value='name'>Name</option>
				<option value='desc'>Description</option>
			</select></td>
			<td style='width:9%'>Search Key:</td>
			<td style='width:40%'>
		<!--		<input type='text' id='toSearch' size=65 value='search' style='color:grey;'> -->
				<input type='text' id='search-field' size=65 value='search' style='color:grey;'>
			</td>
			<td style='width:5%'><input type='button' id='search-button' value='Search for an Item' class='button' ></td></tr>
			</table>
		<!-- This holds the search key (itemID) -->
		<input type='text' id='search-key' hidden='hidden'/>
		</div>
		<div id='search-result' align='center' style='margin-top:3%;'>
		
		</div>
	</div>
</div>

<!-- jQuery Dialogs -->

<!-- End jQuery Dialog -->