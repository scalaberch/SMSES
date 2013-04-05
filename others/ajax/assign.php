<script type='text/javascript'>
	$(function () {
		$('#resign-user').button()
			.click( function () {
				var message = "Are you sure do you want to resign the user? \nRemember, he/she is still logged in after you resign him/her but he/she cannot access it the next time he/she logs in.";
				var sure = confirm(message);
				if (sure){
					var churva = $('#currentComputerField').val();
					$.ajax({
						url:"ajax/assignAJAX.php?resign",
						type:"POST", data:{ cptrID: churva },
						success: function (data) {
							$('#computerDialog').dialog('close');
							window.open('?assign', '_self');
						}
					});
				}
			}
		);
		$('#assign-user').button()
			.click( function () {
				var churva = $('#currentComputerFieldAssign').val();
				var userID = $('#assign-employee-field	').val();
				$.ajax({
					url:"ajax/assignAJAX.php?assign",
					type:"POST", data:{ cptrID: churva, id:userID },
					success: function (data) {
						$('#computerDialog').dialog('close');
						window.open('?assign', '_self');
					}
				});
			}
		);
	
	
	});
</script>
<?php
include "C:/wamp/www/SMSES/lib/ProjectLibrary.php";
session_start();

$connection = new DatabaseConnection();



if (isset($_GET['showComputerInfo'])){
	//check if there is a user:
	$id = $_POST['cptr']; $thereIsUser = false; $user = null;
	$query = mysql_query("SELECT * FROM computer WHERE computerID=$id");
	while($result = mysql_fetch_array($query)){
		if ($result['computerUser'] != null){
			$thereIsUser = true;
			$user = new Employee($result['computerUser']);
		}
	}
	
	if ($thereIsUser){
		echo "
			<p>
			Currently, ".$user->getName()."( ".$user->getRole()." ) is using the said workstation. You may wait for the
				person to finish his/her time or you may resign the employee in the said workstation.
			</p>
			<input type='button' style='width:100%' id='resign-user' value='Click here to resign user.' />
			<input type='text' id='currentComputerField' hidden='hidden' value='$id' />
	";
	}
	else {
		echo "
			<p>
				Assigning employee to computer...<br />
				Enter Employee ID: <input type='text' id='assign-employee-field' />
				<input type='button' style='width:100%' id='assign-user' value='Assign user.' />
				<input type='text' id='currentComputerFieldAssign' hidden='hidden' value='$id' />
			</p>
		";
	}
	
}



?>