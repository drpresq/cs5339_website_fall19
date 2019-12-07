<?php include('gate.php'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Member Dashboard</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="header">
			<h2>Member Dashboard</h2>
		</div>

		<div class="content">
			<form method="post" action="membersDashboard.php">
				<input type="submit" name="logOut" class="btn" value="Log out"/>
			</form>	
		</div>

		<div class="content">
			<h2> <?php echo $_SESSION['username']?>  You're a Member!!!</h2>
		</div>

	</body>
</html>