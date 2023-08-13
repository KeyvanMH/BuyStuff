<?php
require_once '../security.session.php';
//here we assume that user went to his bank account and payed the price completly and now has came back here and everything worked out perfectly
try {
    $conn=new PDO('mysql:host=localhost;dbname=myDB','root','');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
  }


foreach ($_SESSION['cart'] as $key => $row) {
    $product=$row['product'];//id
    $quantity=$row['quantity'];//amount of user's order
    $stmt=$conn->prepare('SELECT amount FROM products WHERE id=:id');
    $stmt->bindParam('id',$product);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    $remain=$result['amount']-$quantity;
    
    if ($remain>=0) {
        $update=$conn->prepare('UPDATE products SET amount=:amount WHERE id=:id');
        $update->bindParam('amount',$remain);
        $update->bindParam('id',$product);
        $update->execute();
        unset($_SESSION['cart']);
        header('location:main.php');
    }else{
        $update=$conn->prepare('UPDATE products SET amount="0" WHERE id=:id');
        $update->bindParam('id',$product);
        $update->execute();
        unset($_SESSION['cart']);
        header('location:main.php');
    }

}

