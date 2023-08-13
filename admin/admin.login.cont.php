<?php
    require_once '../security.session.php';
    $user=$_POST['username'];
    $pass=$_POST['password'];

    // Connect to database using PDO
    $dsn = "mysql:host=localhost;dbname=myDB";
    $username_db = "root";
    try {
      $pdo = new PDO($dsn, $username_db, '');
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Connection failed: " . $e->getMessage());
    }
  
    // search for the given user and pass in database , in case they exist, put them in variable
    $stmt = $pdo->prepare("SELECT username,password FROM managers WHERE username = :username  ");
    $stmt->bindParam(":username", $user);
    $stmt->execute();
    $dbinfo = $stmt->fetch(PDO::FETCH_ASSOC);
    //if the user and password sent from user is NULL somehow, it will get user back to login page
    if ($user==NULL or $pass==NULL) {
      header('location:admin.login.php');
      
    }else{
       //check if database username is equal to the username that is sent from user
      if ($dbinfo['username']==$user ) {
        //check if the password from user is equal to database password
        if ($dbinfo['password']==$pass) {
            $_SESSION['manager']=$user;
            header('location:admin.php');
        }elseif ($dbinfo['password']!==$pass) {
            $_SESSION['PassMatch']='true';
            header('location:admin.login.php');
          } 
          
      }elseif ($dbinfo['username']!==$user ) {
        $_SESSION['PassMatch']='false';
        header('location:admin.login.php');
        }
      }
    
  
    

  

