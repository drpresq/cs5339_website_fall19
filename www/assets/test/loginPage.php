<?php include('memberLogic.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="header">
		<h2>Login</h2>
	</div>

	<ul class="menu">
  		<li><a href="publicPage.php">Home</a></li>
  		<li style="float:right;"><a href="adminLogin.php">Admins</a></li>
	</ul>

	
	<form method="post" action="loginPage.php">
	<div class="fields" align="center">

		<div class="inputLine">
			<label>Username</label>
			<input type="text" name="username" >
		</div>
		<div class="inputLine">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<div class="inputLine">
			<button type="submit" class="btn" name="login_user">Login</button>
		</div>
		<p>
			Not yet a member? <a href="memReg.php">Register</a>
		</p>
	</div>

	</form>

</body>
</html>