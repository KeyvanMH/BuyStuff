<?php 
require_once '../security.session.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="../css/login.page.styles.css">
</head>
<body>
    <div class="container">
	<form action="signup.cont.php" method="post">
		<label for="username">Username:</label>
		<div>
		<input type="text" id="username" name="username" required>
		<h5><?php if(!empty($_SESSION['UserExist'])){if($_SESSION['UserExist']==true){echo 'Username Exist!';}session_unset();}
		?></h5></div>

		<label for="password">Password:</label>
		<input type="password" id="password" name="password" required><br><br>

		<label for="repeat-password">Repeat Password:</label>
		<div>
		<input type="password" id="repeat-password" name="repeat-password" required>
		<h5><?php if(!empty($_SESSION['rPass'])){if($_SESSION['rPass']==true){echo 'wrong password!';}session_unset();}
		?></h5>
		</div>
		</br>
		</br>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required><br><br>

		<input type="submit" value="Sign Up">
	</form>
    <p>Do you have an account? click <a href='../login/login.page.php'>here</a></p>
    </div>
	<div class="copyright">
         &copy; 2012-<?php echo date('Y');?> Buy Stuff. All rights reserved.
      </div>
</body>
</html>
