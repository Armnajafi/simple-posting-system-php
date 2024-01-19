<?php
session_start();
include "../db.php";
include "../classes/User.class.php";
include "../classes/Auth.class.php";


if(isset($_POST["fname"] , $_POST["lname"] ,  $_POST["email"] ,  $_POST["password"] ,  $_POST["repassword"]))
{
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];

    $register = new Auth();
    $user_c = new User();

    $register->dbh = $dbh;
    $user_c->dbh = $dbh;

    if($fname && $lname && $email && $password && $repassword){
        $register->fname = $fname;
        $register->lname = $lname;
        $register->email = $email;
        $register->password = $password;
        if($register->checkPasswordStrength($password)){

            if($register->checkPasswordRepeat($password  , $repassword)){

                if($register->isValidEmail($email)){

                    if($user_c->getUser($email) == false){
     
                        $register->register();
                        echo "Register Successfuly";
    
                    } else {
    
                        echo "Email is already";
    
                    }
    
                } else {
                    echo "Email format is Invalid";
                }
    
            } else {
                echo "Password and Repassword is not Same";
            }

        } else {
            echo "Password is not strong";
        }
    
    } else {
        echo "Please fill out the form";
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
</head>
<body>
    <h1>Register Form</h1>
    <form action="" method="post">  
        <input type="text" name="fname" placeholder="Enter First Name"><br>
        <input type="text" name="lname" placeholder="Enter Last name"><br>
        <input type="email" name="email" placeholder="Enter Email"><br>
        <input type="text" name="password" placeholder="Enter Password"><br>
        <input type="password" name="repassword" placeholder="Enter Repeat Password"><br>
        <button type="submit">Register</button> <a href="login.php">Login Page</a>
    </form>
</body>
</html>