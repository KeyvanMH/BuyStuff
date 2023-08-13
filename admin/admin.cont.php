<?php
require_once '../security.session.php';
if (isset($_SESSION['manager'])) {
//conncection with database
try {
    $conn=new PDO('mysql:host=localhost;dbname=myDB','root','');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
  }

  //insert datat in database
if (isset($_POST['insert'])) {
  $name=$_POST['name'];
  $amount=$_POST['amount'];
  $brand=$_POST['brand'];
  $price=$_POST['price'];

  $stmt=$conn->prepare("INSERT INTO products (name, brand ,amount,price) VALUES(:name,:brand,:amount,:price)");
  $stmt->bindParam(':name',$name);
  $stmt->bindParam(':brand',$brand);
  $stmt->bindParam(':amount',$amount);
  $stmt->bindParam(':price',$price);
  $stmt->execute();
  header('location:admin.php');
}

// change data base info
if(isset($_POST['update'])){
  $name=$_POST['name'];
  $id=$_POST['id'];
  $amount=$_POST['amount'];
  $brand=$_POST['brand'];
  $price=$_POST['price'];

  $stmt=$conn->prepare("SELECT id FROM products WHERE id=:id");
  $stmt->bindParam(':id',$id);
  $stmt->execute();
  $dbinfo = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!empty($dbinfo)) {
      $stmt=$conn->prepare("UPDATE products SET name=:name , brand=:brand , amount=:amount , price=:price WHERE id=:id");
      $stmt->bindParam(':name',$name);
      $stmt->bindParam(':brand',$brand);
      $stmt->bindParam(':amount',$amount);
      $stmt->bindParam(':id',$id);
      $stmt->bindParam(':price',$price);
      $stmt->execute();
      header('location:admin.php');
   }else{
      $_SESSION['NameError']='NotFound';
      header('location:admin.php');
  }
}

//delete database info
if (isset($_POST['delete'])) {
  $id=$_POST['id'];
  $stmt=$conn->prepare("SELECT id FROM products WHERE id=:id");
  $stmt->bindParam(':id',$id);
  $stmt->execute();
  $dbinfo = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!empty($dbinfo)) {
    $stmt=$conn->prepare("DELETE FROM products WHERE id=:id ");
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    header('location:admin.php');
  }else{
    $_SESSION['NameError']='NotFound';
      header('location:admin.php');
  }
}

//show data base to user
if (isset($_POST['show'])) {
  $name=$_POST['name'];

  $stmt=$conn->prepare("SELECT id,name,brand,amount,price FROM products WHERE name=:name ");
  $stmt->bindParam(':name',$name);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Display the results
  if (!empty($result)) {
    foreach($result as $row) {
      echo "<link rel='stylesheet' type='text/css' href='../css/main.page.css'>";
      echo "<h4 class='item1 '>
      -ID: " . htmlspecialchars($row["id"])."</br> 
      - Name: " . htmlspecialchars($row["name"])."<br> 
      - Amount:".htmlspecialchars($row['amount'])."<br>
      - brand:".htmlspecialchars($row['brand'])."</br>
      - price: ".htmlspecialchars($row['price'])."</h4><br>"; 
    }
    echo " <p class='footer'> click <a href='admin.php'> here </a>to go back to first page</p>";
  } elseif (empty($result)) {
    echo "<link rel='stylesheet' type='text/css' href='../css/main.page.css'>";
    echo "<h3 >no data exist with this name!</h3> ";
    echo "</br> <p class='footer'> click <a href='admin.php'> here </a>to go back to first page</p>";
  }
}
}else{
  session_unset();
  header('location:admin.login.php');
}
