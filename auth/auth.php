<?php
include '../lib/ProjectLibrary.php';
session_start();
//include 'lib/library.php';

//TODO:
//Store this into the class (from the Class Diagram)

function isAuthenticated() {
	if (($nnn["employeeID"] == $_POST["userName"] and $nnn["employeePassword"] == $_POST["passWord"])){
		return true;
	}
	return false;
	//append (this and $nnn['employeePosition'] == Supervisor (OR) Financial Manager
}

function authenticate_managers($username, $password){
	//Precondition: System is already connected to the database...
	//Postcondition: System logs in the user that is a manager;
	
	$result = mysql_query("SELECT * FROM employee", $db);
    while($nnn = mysql_fetch_array($result)){
        if(isAuthenticated()){
			//store_logger_data_to_session();
		
			echo "true";
			break;
        }
    }
	
}

function is_employee_in_db($employeeID){
	$return = false;
	$query = "SELECT employeeID FROM employee WHERE employeeID='".$employeeID."' ";
	$query_result = mysql_query($query);
	while($result = mysql_fetch_array($query_result)){
		if ($result['employeeID'] == $employeeID){
			$return = true;
		}
	}
	return $return;
}

function get_employee_password($employeeID){
	$password = null;
	$query = "SELECT employeePassword FROM employee WHERE employeeID='".$employeeID."' ";
	$query_result = mysql_query($query);
	while($result = mysql_fetch_array($query_result)){
		$password = $result['employeePassword'];
	}
	return $password;
}

$connection = new DatabaseConnection();

//Sample Data Usage:
//$_POST['userName'] = "90414";

//Initalizing the object


if (isset($_POST['userName'])){
	$employee = new Employee($_POST['userName']);
}

if (isset($_GET['verifyUser']))
{
	$password = $_POST['passWord'];
	if (is_employee_in_db($employee->getID())){
		$sql = "SELECT employeePassword FROM employee WHERE employeeID=".$employee->getID();
		$query = mysql_query($sql);
		while($result = mysql_fetch_array($query)){
			if ($result['employeePassword'] == $password){
				echo "true"; 
			}
		}
	}
	else { echo "false"; }
}
else if (isset($_GET['checkIfAssigned'])){
	$myname = $employee->getName();	
	$role = $employee->getRole();
	
	$is_current_user_assigned_here = false;
	$myip = getenv("REMOTE_ADDR");
	$query = "SELECT computerUser FROM computer WHERE computerIPAddress='$myip' ";
	$query_result = mysql_query($query);
	while($result = mysql_fetch_array($query_result)){
		if ($result['computerUser'] == $employee->getID() ){
			$is_current_user_assigned_here = true;
		}
	}
	if (($role == "Cashier" or $role == "Attendant") and !$is_current_user_assigned_here){
		echo "false";
	}
	else {
		echo "true";
	}
	
	
}
else if (isset($_GET['authSucess'])){
	$_SESSION['position'] = $employee->getRole();
	/* Input everything in the SESSION variable */
	$_SESSION['user'] = $employee;
	//Update Computer List...
	$myip = getenv("REMOTE_ADDR");
	$query = "UPDATE computer SET computerUser='".$employee->getID()."' WHERE computerIPAddress='$myip' ";
	mysql_query($query);
}
else if (isset($_GET['authFail'])){
	$myname = $employee->getName();	
	echo "
		<script type='text/javascript'>
			$('#exit-button')
				.button()
				.click(function () { $('#authentication-form').dialog('close'); } );
		</script>
		
		Hello, $myname.  It seems that you are not assigned by your respective manager to this
		computer. Please consult your respective manager/supervisor for your login purposes.<br />
		<br />
		<input type='button' id='exit-button' style='width:99%;' value='OK' />
		
		";

}
//
//
/*
else if (isset($_GET['fillAuthenticateUser']))
{
	$myname = $employee->getName();	
	$role = $employee->getRole();
	
	$is_current_user_assigned_here = false;
	$myip = getenv("REMOTE_ADDR");
	$query = "SELECT computerUser FROM computer WHERE computerIPAddress='$myip' ";
	$query_result = mysql_query($query);
	while($result = mysql_fetch_array($query_result)){
		if ($result['computerUser'] == $employee->getID() ){
			$is_current_user_assigned_here = true;
		}
	}
	//mysql_query($query);

	if (($role == "Cashier" or $role == "Attendant") and !$is_current_user_assigned_here){
		//Get the Computer List
		echo "
		<script type='text/javascript'>
			$('#exit-button')
				.button()
				.click(function () { $('#authentication-form').dialog('close'); } );
		</script>
		
		Hello, $myname.  It seems that you are not assigned by your respective manager to this
		computer. Please consult your respective manager/supervisor for your login purposes.<br />
		<br />
		<input type='button' id='exit-button' style='width:99%;' value='OK' />
		
		";
	}
	else {
		echo "<script type='text/javascript'> append_password_settings(); </script>";
		echo "Hello, $myname.  To continue, please enter your password. <br />";
		echo "<input type='text' id='password-field' value='Enter your password here...' class='login-form-field' style='width:99%'/><br />";
		echo "
			<div id='error-password-manager' class='ui-state-error ui-corner-all' align='center' style='padding:0.7 em;color:red;'> 
				Wrong Password. Please try again.
			</div>
		";
		echo "<input type='button' id='login-button' value='Login to SMSES' style='width:99%' />";
	}
}

else if (isset($_GET['authenticateUser'])){
	//$_POST['passWord'] = "drag";
	$inputted_password = $_POST['passWord'];
	$password = get_employee_password($employee->getID());
	if ($password == $inputted_password){
		echo "true";
		
		$_SESSION['position'] = $employee->getRole();
		/* Input everything in the SESSION variable */ /*
		$_SESSION['user'] = $employee;
		//Update Computer List...
		$myip = getenv("REMOTE_ADDR");
		$query = "UPDATE computer SET computerUser='".$employee->getID()."' WHERE computerIPAddress='$myip' ";
		mysql_query($query);
	}
	else { echo "false"; }
}
*/
/*
if (isset($_POST["userName"]) and isset($_POST["passWord"])){
    authenticate_managers($_POST["userName"], $_POST["passWord"]);
}
*/

?>
