<?php
session_start();

include "../db.php";
include "../classes/Auth.class.php";

$login = new Auth();
$login->dbh = $dbh;

if($login->checkLoginUser()){
    return header("location: user/index.php");
} else if($login->checkLoginAdmin()){
    return header("location: admin/index.php");

}


if(isset($_POST["email"] , $_POST["password"])){
    $email = $_POST["email"];
    $password = $_POST["password"];


    $login->email = $email;
    $login->password = $password;

    if($login->login() == 1){
        $_SESSION["isUser"] = true;
        $_SESSION["isAdmin"] = false;
        $_SESSION["email"] = $email;
        header("location: user/index.php");
    } else if ($login->login() == 2) {
        $_SESSION["isUser"] = false;
        $_SESSION["isAdmin"] = true;
        $_SESSION["email"] = $email;
        header("location: admin/index.php");
    } else {
        echo "Email or password is invalid";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
</head>
<body>
    <form action="" method="post">
        <h1>Login Form</h1>
        <input type="text" name="email" placeholder="Enter username"><br>
        <input type="password" name="password" placeholder="Enter password"><br>
        <button type="submit">Login</button> <a href="register.php">Register page</a>
    </form>
</body>
</html>