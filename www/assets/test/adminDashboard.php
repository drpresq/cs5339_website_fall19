<?php

session_start();

if (isset($_POST['logOut'])) {
		session_destroy();
		unset($_SESSION['username']);
		unset($_SESSION['adminUsername']);
		header("location: loginPage.php");
}

if(!isset($_SESSION['adminUsername'])){
	$_SESSION['msg'] = "You're not logged in as an Administrator";
	header('location: adminLogin.php');
}

if(isset($_POST['regNewAdmin'])){
	header('location: adminReg.php');
}

if(isset($_POST['delUser'])){
	header('location: delUser.php');
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Admin Dashboard</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="header">
			<h2>Admin Dashboard</h2>
		</div>

		<div class="content">
			<form method="post" action="adminDashboard.php">
				<input type="submit" name="regNewAdmin" class="btn" value="Register New Admin"/>
				<input type="submit" name="delUser" class="btn" value="Delete User"/>
				<input type="submit" name="logOut" class="btn" value="Log out"/>
			</form>	
		</div>

		<div class="content">
			<h2>You're an admin!!!</h2>
		</div>

	</body>
</html>