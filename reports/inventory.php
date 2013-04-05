<?php
	$connection = new DatabaseConnection();
?>
<script type='text/javascript'>
$( function () {
	var categoryname = $('#category').val();
	var suppliername = $('#supplier').val();
	$.ajax({
		url: "fetcher.php",
		datatype: "html",
		type: "POST",
		data: {
			catname: categoryname,
			supname: suppliername
		},
		success: function(data){
			$('#incontent').html("");
			$('#incontent').html(data);
		
		}
	});
	$('#category').change(function (){
	var categoryname = $('#category').val();
	var suppliername = $('#supplier').val();
	
		$.ajax({
			url: "fetcher.php",
			datatype: "html",
			type: "POST",
			data: {
				catname: categoryname,
				supname: suppliername
			},
			success: function(data){
				$('#incontent').html("");
				$('#incontent').html(data);
			
			}
		});
	
	});
	
	$('#supplier').change(function (){
	var categoryname = $('#category').val();
	var suppliername = $('#supplier').val();
	
		$.ajax({
			url: "fetcher.php",
			datatype: "html",
			type: "POST",
			data: {
				catname: categoryname,
				supname: suppliername
			},
			success: function(data){
				$('#incontent').html("");
				$('#incontent').html(data);
			
			}
		});
	
	});



});

</script>
<div id='content-container' align='center'>
	<div id='content' align='left' class='rounded-corners'>
		<div id='content-title'>
			Generate Inventory Reports
		</div>
		<div id='content-menu-buttons'>
			<ul class='ui-widget ui-helper-clearfix'>
				<li><a href='?'>Back to Reports Menu&nbsp </a></li>
			</ul>
		</div>
		<div style='margin-top:3%'>
		<select id='category'>
		<option>All</option>
		<?php
			$query = "SELECT categoryName, categoryID FROM category";
			$qresult = mysql_query($query);
			while($result = mysql_fetch_array($qresult)){
				echo "<option id=".$result['categoryID'].">".$result['categoryName']."</option>";
			}
		?>
		</select>
		<select id='supplier'>
		<option>All</option>
		<?php
			$query = "SELECT SupplierName, SupplierID FROM supplier";
			$qresult = mysql_query($query);
			while($result = mysql_fetch_array($qresult)){
				echo "<option id=".$result['SupplierID'].">".$result['SupplierName']."</option>";
			}
		?>
		</select>
		</div>
		<div id='incontent' style = 'margin-top:3%;width:100%'>
		
		</div>
	</div>
</div>