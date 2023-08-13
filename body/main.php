<?php
require_once '../security.session.php';

//which user is in website
if (isset($_SESSION['person'])) {
    //connection with database
    try {
        $conn=new PDO('mysql:host=localhost;dbname=myDB','root','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
      }
      $stmt=$conn->prepare('SELECT * FROM products');
      $stmt->execute();
      $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

         <!DOCTYPE html>
   <html>
   <head>
       <title>Buy Stuff Page</title>
       <link rel="stylesheet" type="text/css" href="../css/main.page.css">
   </head>
   <body>
       <header class="header">
           <h1>Buy Stuff Page</h1>
           <form method="post" action="main.php">
            <button type="submit" name="logout" value="logout" style="float: right;">Log out</button>
            <?php if (!empty($_POST['logout'])) {
                session_unset();
                header('location:../login/login.page.php');
            } ?>
        </form>
        <div class="greeting"><?php echo 'WELLCOME '.$_SESSION['person']; ?></div>
       </header>
       
       <main>
       <div class="item-container">
        <?php 
        foreach ($result as $row) {
            echo '
            <div class="item">
                <img src="https://via.placeholder.com/150x140" alt="Item ">
                <h2>'.htmlspecialchars($row['name']).'</h2>
                <p>BRAND : '.htmlspecialchars($row['brand']).'</p>
                <p>REMAINING : '.htmlspecialchars($row['amount']).'</br>
                <p>PRICE : '.htmlspecialchars($row['price']).'$
                <form method="post" action="main.php">';
                    if($row['amount']!==0){
                        echo'
                        <input type="number" name="number" min="1" max='.$row['amount'].'  required></br></br>
                        <button type="submit" name="product" value="'.$row['id'].'">Add To Cart</button>
                        </form>
                         </div>';
                        }elseif ($row['amount']==0) {
                            echo '<h2 style="color:red"> out of order!</h2>
                            </form>
                            </div>';
                        }
        }

        //this part activate's cart sessoin for user if not activated from login or signup page to store stuff in it and then buy it
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart']=array();
            if (!empty($_POST['product'])) {
                $holder=["product"=>$_POST['product'],"quantity"=>$_POST['number']];
                array_push($_SESSION['cart'],$holder);
              }
        }elseif (isset($_SESSION['cart'])) {
             if (!empty($_POST['product'])) {
                  $holder=["product"=>$_POST['product'],"quantity"=>$_POST['number']];
                  array_push($_SESSION['cart'],$holder);
                }
        }
        ?>
           </div>  
       </main>
   
   <footer class="footer">
      <a href="payment.page.php"> <button >Payment Page</button></a>
   </footer>
   
   </body>
   </html>

   <?php
}else {
    header('location:../login/login.page.php');
}
?>