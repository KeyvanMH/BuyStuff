<?php 
require_once '../security.session.php';
if (isset($_SESSION['manager'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/login.page.styles.css">
    <title>buy stuff admin</title>
</head>
<body>
    <div class="container">
    <form class='bottun' method="post" action="admin.php">
        <button type="submit" name="insert" value="insert" class="button">insert </button>
        <button type="submit" name="update" value="update" class="button"> update</button>
        <button type="submit" name="delete" value="delete" class="button"> delete</button>
        <button type="submit" name="select" value="select" class="button"> show</button>
    </form><?php
        if (!empty($_SESSION['NameError'])) {
            echo '<p style="color:red;">No Name Found!</p>';
            unset($_SESSION['NameError']);
        }
        ?>
        
    <?php 
    if (!empty($_POST['insert'])) {
    ?> <div>
    <h3>insert product</h3>
    <form method="post" action="admin.cont.php" class="form">
        <label for="name">product name: </label>
        <input type="text"  id="name" name="name" required></br>
        <label for="amount">product amount: </label>
        <input type="number" id="amount" name="amount" min="0" required></br>
        <label for="brand">product brand: </label>
        <input type="text" id="brand" name="brand" required></br>
        <label for="price">product price: </label>
        <input type="text" id="price" name="price" required></br>
        <input type="hidden" name="insert" value="insert">
        <input type="submit"></br>
    </from>
    </div>
    <?php
    }
    ?>
    <?php 
    if (!empty($_POST['update'])) {
    ?><div>
    <h3>update product information</h3>
    <form method="post" action="admin.cont.php" class="form">
        <label for="id">product id: </label>
        <input type="text"  id="id" name="id" required>
        </br>
        <label for="name">change product name: </label>
        <input type="text"  id="name" name="name" required>
        </br>
        <label for="amount">change product amount: </label>
        <input type="number" id="amount" name="amount" min="0" required>
        </br>
        <label for="brand">change product brand: </label>
        <input type="text" id="brand" name="brand" required>
        </br>
        <label for="price">change product price: </label>
        <input type="text" id="price" name="price" required></br>
        <input type="hidden" name="update" value="update">
        <input type="submit">
        </from>
        </div>
    <?php
    }
    ?>

    <?php 
    if (!empty($_POST['delete'])) {
        ?>
        <div>
        <h3>delete product </h3>
        <form method="post" action="admin.cont.php" class="form">
            <label for="delete"> product ID:</label>
            <input type="text"  id="id" name="id" required >
            </br>
            <input type="hidden" name="delete" value="delete">
            <input type="submit">
        </from>
    </div>
    <?php
    }
    ?>

<?php
if (!empty($_POST['select'])) {
?>
<div>
<h3>show product </h3>
<form method="post" action="admin.cont.php" class="form">
    <label for="show"> product name:</label>
    <input type="text"  id="name" name="name" required >
    </br>
    <input type="hidden" name="show" value="show">
    <input type="submit"></br>
</from>
</div>
</div>
<?php
}
}else{
    session_unset();
    header('location:admin.login.php');
}
?>

</body>
</html>