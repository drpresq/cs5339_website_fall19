<?php 
include('memberLogic.php'); 
?>
<!DOCTYPE html>
<html>

<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

	<div class="header">

		<h2>Register</h2>

	</div>

	<ul class="menu">
  		<li><a href="publicPage.php">Home</a></li>
  		<li style="float:right;"><a href="adminLogin.php">Admins</a></li>
	</ul>
	
	<form method="post" action="memReg.php" >

	<div class="fields" align="center">

		<div class="inputLine">
			<label>Username</label>
			<input type="text" name="username" value=""/>
		</div>

		<div class="inputLine">
			<label>Email</label>
			<input type="email" name="email" value=""/>
		</div>

		<div class="inputLine">
			<label>Password</label>
			<input type="password" name="password_1"/>
		</div>

		<div class="inputLine">
			<label>Confirm password</label>
			<input type="password" name="password_2"/>
		</div>

		<div class="inputLine">
			<button type="submit" class="btn" name="reg_user">Register</button>
		</div>

		<p>
			Already a member? <a href="loginPage.php">Sign in</a>
		</p>

	</div>	

	</form>
</body>
</html>