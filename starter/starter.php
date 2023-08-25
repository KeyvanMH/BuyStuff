<!DOCTYPE html>
<html>
  <head>
    <title>Buy Stuff</title>
    <link rel="stylesheet" href="../css/starter.css">
  </head>
  <body>
    <div class="header">
      <a href="../login/login.page.php"><button class="login-button">Login</button></a>
      <a href="../signup/signup.page.php"><button class="signup-button">Sign Up</button></a>
    </div>

    <div class="main">
      <img src="cute.boy.jpg" style="height: 100%; width: 100%; object-fit: cover;" alt="Description of image">
      <div class="hero">
        <h1>Buy Stuff</h1>
        <p>Your one-stop shop for all your needs</p>
      </div>
    </div>
    <div class="footer">
      <div class="contact">
        <a href="#">Contact Us</a>
        <a href="../admin/admin.login.php">Manager Login</a>
      </div>
      <p>&copy; <?php echo date("y") ?> Buy Stuff. All rights reserved.</p>
    </div>
  </body>
</html>
<?php
// this is for localhost runner who need's to DataBase table creat's in his pc to run the website
$dsn = "mysql:host=localhost;dbname=myDB";
    $username_db = "root";
    try {
      $conn = new PDO($dsn, $username_db, '');
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Connection failed: " . $e->getMessage());
    }
    $conn->exec('CREATE TABLE IF NOT EXISTS myguests (
      id INT NOT NULL AUTO_INCREMENT,
      username VARCHAR(50) NOT NULL,
      password VARCHAR(50) NOT NULL,
      email VARCHAR(50) NOT NULL,
      PRIMARY KEY (id)
      );');
    $conn->exec('CREATE TABLE IF NOT EXISTS managers (
      id INT NOT NULL AUTO_INCREMENT,
      username VARCHAR(50) NOT NULL,
      password VARCHAR(50) NOT NULL,
      email VARCHAR(50) NOT NULL,
      PRIMARY KEY (id)
      );');
    $conn->exec('CREATE TABLE IF NOT EXISTS products (
      id INT NOT NULL AUTO_INCREMENT,
      name VARCHAR(50) NOT NULL,
      brand VARCHAR(50) NOT NULL,
      amount INT NOT NULL,
      price INT NOT NULL,
      PRIMARY KEY (id)
      );');

    $stmt=$conn->prepare('SELECT id FROM managers WHERE id="1";');
    $stmt->execute();
    $manager_result=$stmt->fetch(PDO::FETCH_ASSOC);

    $stmt=$conn->prepare('SELECT id FROM myguests WHERE id="1";');
    $stmt->execute();
    $guest_result=$stmt->fetch(PDO::FETCH_ASSOC);

    $stmt=$conn->prepare('SELECT id FROM products WHERE id="1";');
    $stmt->execute();
    $product_result=$stmt->fetch(PDO::FETCH_ASSOC);

      if (!isset($manager_result['id'])) {
      $conn->exec('INSERT INTO managers(username,password,email) VALUES ("admin","admin","admin@gmail.com");');
      }


      if (!isset($guest_result['id'])) {
        $conn->exec('INSERT INTO myguests(username,password,email) VALUES ("user","user","user@gmail.com");');
      }


      if (!isset($product_result['id'])) {
        $conn->exec('INSERT INTO products(name,brand,amount,price) VALUES
          ("13promax","apple","1000","499"),
          ("s23ultra","samsung","0","499"),
          ("iphone6","apple","20","299"),
          ("iphone5","apple","30","600"),
          ("iphone10","apple","40","199"),
          ("note8","xiaomi","200","399"),
          ("note10","xiaomi","150","499")
          ;');
      }


?>
