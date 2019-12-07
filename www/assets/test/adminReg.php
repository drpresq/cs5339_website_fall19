<?php

require_once('connect.php'); 

//reg admin user
if (isset($_POST['reg_admin']) && isset($_SESSION['adminUsername'])) {
	
	$username 	= 	mysqli_real_escape_string($db, $_POST['username']);
	$email 		= 	mysqli_real_escape_string($db, $_POST['email']);
	$password_1 = 	mysqli_real_escape_string($db, $_POST['password_1']);
	$password_2 = 	mysqli_real_escape_string($db, $_POST['password_2']);
	
	if (empty($username)) { array_push($errors, "Username is required"); }
	if (empty($email)) { array_push($errors, "Email is required"); }
	if (empty($password_1)) { array_push($errors, "Password is required"); }

	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	if (count($errors) == 0) {
		$password = md5($password_1);
		$query = "INSERT INTO admins (username, email, password) 
				  VALUES('$username', '$email', '$password')";
		mysqli_query($db, $query);
		header('location: adminLogin.php');
	}else{
		echo "please check your input";
	}

}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Register New Admin</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

	<div class="header">

		<h2>Register New Admin</h2>

	</div>

	<ul class="menu">
  		<li style="float:right;"><a href="adminDashboard.php">Dashboard</a></li>
	</ul>
	
	<form method="post" action="adminReg.php" >


	<div class="fields" align="center">

		<div class="inputLine">
			<label>Username</label>
			<input type="text" name="username" value="">
		</div>

		<div class="inputLine">
			<label>Email</label>
			<input type="email" name="email" value="">
		</div>

		<div class="inputLine">
			<label>Password</label>
			<input type="password" name="password_1">
		</div>

		<div class="inputLine">
			<label>Confirm password</label>
			<input type="password" name="password_2">
		</div>

		<div class="inputLine">
			<button type="submit" class="btn" name="reg_admin">Sign up</button>
		</div>

	</div>	

	</form>
</body>
</html>