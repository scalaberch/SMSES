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
	
	/* Override background...
	*/
	
	#content {
		height:100%;
	}
	#finance-report-table th{
		background-color:white; color:black;
	}
	#finance-report-table td{
		border-bottom:1px dotted white;padding:5px;
	}
	#finance-report-table tr:hover{
		background-color:white; color:black;
	}
	</style>
<script type='text/javascript'>
	$(function() {
		$('.computerList')
			.click(function(){
				var id = $(this).attr("id");
				$.ajax({
					url:"ajax/assign.php?showComputerInfo",
					datatype:"html", type:"POST",
					data: { cptr: id },
					success: function (data) {
						$('#computerDialog').html(data);
						$('#computerDialog').dialog('open');
						
					}
				});
			}
		);
		
		$('#computerDialog').dialog({autoOpen:false, modal:true});
	});
</script>
<div id='content-container' align='center'>
	<div id='content' align='left' class='rounded-corners'>
		<div id='content-title'>
			Assign Employee to Workplace
		</div>
		<div id='content-menu-buttons'>
			<a href='?'>Back to Others Menu &nbsp </a>
		</div>
		
		
		<div style='margin-top:40px;'>
			<i> Select a workstation below to assign new user. </i>
			<table id='finance-report-table' cellspacing=0 style='width:100%'>
				<th>Workstation Name</th><th>Location</th><th>IP Address</th><th>Current User</th><th>Position</th>
		<?php
			$con = new DatabaseConnection();
			$query = mysql_query("SELECT * FROM computer");
			while($result = mysql_fetch_array($query)){
				echo "<tr class='computerList' id='".$result['computerID']."'>"; //fix: add a jquery action if click...
				echo "<td>".$result['computerName']."</td>";
				echo "<td>".$result['computerLocation']."</td>";
				echo "<td>".$result['computerIPAddress']."</td>";
				if ($result['computerUser'] == null){
					echo "<td>NONE</td>";	
					echo "<td>NONE</td>";	
				}else {
					$employee = new Employee($result['computerUser']);
					echo "<td>".$employee->getName()."</td>";
					echo "<td>".$employee->getRole()."</td>";
				}
				
				
				echo "</tr>";
			}
		
		
		?>
			</table>
		
		
		</div>

	</div>
</div>

<!-- jQuery Dialogs -->
<div id='computerDialog'>


</div>
<!-- End jQuery Dialog -->