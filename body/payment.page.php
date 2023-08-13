<?php 
require_once '../security.session.php';

if (isset($_SESSION['person'])) {
?>
<!DOCTYPE html>
<html>
<head>
	<title>Shopping Cart</title>
	<link rel="stylesheet" type="text/css" href="../css/payment.css">
</head>
<body>
	<header>
		<h1>Shopping Cart</h1>
	</header>

	<main><?php 
	if (!empty($_POST['DeleteOneCart'])) {
		$Delete=$_POST['DeleteOneCart']-1;
		unset($_SESSION['cart'][$Delete]);
	}
	if (!empty($_POST['DeleteAllCart'])) {
		unset($_SESSION['cart']);
	}
	if(!empty($_SESSION['cart'])){ 
        try {
            $conn=new PDO('mysql:host=localhost;dbname=myDB','root','');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
          }
        ?>
		<table>
			<thead>
				<tr>
                    <th>number</th>
					<th>Item Name</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Subtotal</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody><?php
				$result=0;
                $num=1;
                 foreach ($_SESSION['cart'] as $key => $row) {                
                         $stmt=$conn->prepare("SELECT name,price FROM products WHERE id=:id ");
                         $stmt->bindParam(':id',$row['product']);
                         $stmt->execute();
                         $name=$stmt->fetch(PDO::FETCH_ASSOC);
						 $holder=$key;
						 //because the form value doesnt accept 0 value which is first array key
						 $remover=$key+1;
                        echo'<tr>
                        <td>'.$num++.'</td>
				    	<td>'.$name['name'].'</td>
					    <td>'.$name['price'].' $</td>
				    	<td>'.$row['quantity'].'</td>
				    	<td>'.$row['quantity']*$name['price'].' $</td>
				    	<td><form method="post" action="payment.page.php">
						<button type="submit" class="remove-btn" name="DeleteOneCart" value="'.$remover.'">Remove</button>
						</form></td>
				        </tr>';
						$result+=$row['quantity']*$name['price'];
                     }
                
				?>

			</tbody>
			<tfoot>
				<tr>
					<td colspan="4">Total:</td>
					<td><?php
                    echo $result;
					echo ' $';
                    ?></td>
					<td>
						<form method="post" action="payment.page.php">
							<button class="remove-btn" name="DeleteAllCart" value="TRUE">Remove</button>
					</form></td>
				</tr>
			</tfoot>
		</table>
        <?php }else{ echo '<div style="text-align:center;">You Have Nothing In Your Cart!';} ?></br></br>
		<div class="buttoncontainer">
			<form method="post" action="main.php"><button type='submit' class="checkout-btn">Back to Main Page</button></form></br>
			<form method="post" action="payment.cont.php" ><button class="checkout-btn">Proceed to Checkout</button></form>
		</div>

		
	</main>

	<footer>
		<div class="copyright"><p>&copy; 2023 Buy Stuff. All rights reserved.</p></div>
	</footer>

</body>
</html>
<?php
}else {
    header('location:../login/login.page.php');
}
?>