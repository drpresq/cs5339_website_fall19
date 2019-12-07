<?php 

	session_start();

	if (isset($_POST['logOut'])) {
		session_destroy();
		unset($_SESSION['username']);
		unset($_SESSION['adminUsername']);
		header("location: loginPage.php");
	}

	if (!isset($_SESSION['username']) && !isset($_SESSION['adminUsername'])) {
		$_SESSION['msg'] = "You must be logged in first";
		echo "you must be logged in";
		header('location: loginPage.php');
	}

?>