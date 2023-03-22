<?php include('functions.php') ?>
<!DOCTYPE html>
<html> 
<head>
	<title>CBE Login system  </title>
	<link rel="stylesheet" type="text/css" href="loginstyle.css">
</head>
<body>
	<div class="loginsec">
	<form method="post" action="loginindex.php">

		<?php echo display_error(); ?>

		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" >
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password" >
		</div>
		<div class="input">
			<button type="submit" class="btn" name="login_btn" >Login</button>
		</div>
		<p>
			Not yet a member? Contact Admin To <a href="index.php">Signup</a>
		</p>
	</form>
	</div>

</body>
</html>