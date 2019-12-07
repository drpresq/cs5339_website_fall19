<?php 

require_once('connect.php');

// Login Admin user
if (isset($_POST['loginAdmin'])) {

	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	if (count($errors) == 0) {
		
		$password = md5($password);
		$query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) {
			$_SESSION['adminUsername'] = $username;
			$_SESSION['adminSuccess'] = "You are now logged in";
			header('location: adminDashboard.php');
		}else {
			echo "Wrong username or password";
		}
	}
}

?>