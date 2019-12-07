<?php 

require_once('adminLogic.php'); 

?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="header">
		<h2>Admin Login</h2>
	</div>

	<ul class="menu">
  		<li><a href="publicPage.php">Home</a></li>
	</ul>

	<form action="adminLogin.php" method="post" >

	<div class="fields" align="center">
		<div class="inputLine">
			<label>Username</label>
			<input type="text" name="username"/>
		</div>
		<div class="inputLine">
			<label>Password</label>
			<input type="password" name="password"/>
		</div>
		<div class="inputLine">
			<button type= "submit" class= "btn" name= "loginAdmin" value= "login">Login</button>
		</div>
	</div>

	</form>

</body>
</html>