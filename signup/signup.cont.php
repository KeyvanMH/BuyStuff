<?php
require_once '../security.session.php';

//getting info from user
$User=$_POST['username'];
$Pass=$_POST['password'];
$rPass=$_POST['repeat-password'];
$email=$_POST['email'];

//database information's
$servername = "localhost";
$username = "root";
$password = "";

//checking if the second inserted password is same with first one
if ($Pass!==$rPass) {
    //if it is not same, turn back to the signup page
    header('location:signup.page.php');
    $_SESSION['rPass']=true;
}else {
    //if it is same , check if the inserted user is alredy in database or not
        try {
            $conn = new PDO("mysql:host=$servername", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec("USE myDB");
            $stmt = $conn->prepare('SELECT username FROM myguests WHERE username=:username');
            $stmt->bindParam(':username' , $User);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if(!empty($result)){
                    //if the  username exist in database, $result will be true and turn user back to the sign up page
                    header('location:signup.page.php');
                    $_SESSION['UserExist']=true;
                }else {
                    //if there is no username with that name, then we sign up user and insert it to database in head him to the main page
                     try {
                            $conn->beginTransaction();
                            $stmt = $conn->prepare("INSERT INTO myguests (username, password,email) VALUES (:username, :password, :email)");
                            $stmt->bindParam(':username', $User);
                            $stmt->bindParam(':password', $Pass);
                            $stmt->bindParam(':email', $email);
                            $stmt->execute();
                            $conn->commit();
                            //adding user to database and head him to main page
                            $_SESSION['person']=$User;
                            $_SESSION['cart']=array();
                             header('location:../body/main.php');
            
                        } catch(PDOException $e) {
                                 echo "Error: " . $e->getMessage();
                            }
                    }
            }catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                }
                $conn=NULL;
    }