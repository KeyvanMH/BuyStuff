<?php require_once '../security.session.php'; ?>

<!DOCTYPE html>
<html>
  <head>
    <title>Buy Stuff admin</title>
    <link rel="stylesheet" type="text/css" href="../css/login.page.styles.css">
  </head>
  <body>
    <div class="container">
      <form method="post" action="admin.login.cont.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required/>
        <h5><?php if (!empty($_SESSION['PassMatch'])) { if ($_SESSION['PassMatch']=='false') { echo 'no user found!';}}?></h5></br></br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required/>
        <h5><?php if (!empty($_SESSION['PassMatch'])) { if ($_SESSION['PassMatch']=='true') { echo 'wrong password!';}}?></h5></br></br>
        <input type="submit" value="Submit" />
      </form>
    </div>
    <div class="copyright">
      &copy; 2012-<?php echo date('Y');?> Buy Stuff. All rights reserved.
    </div>
    <?php 
      if(!empty($_SESSION['error'])){
        echo $_SESSION['error'];
      }
      session_unset();
    ?>
  </body>
</html>

