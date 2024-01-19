<?php
session_start();

include "../../db.php";
include "../../classes/Auth.class.php";
include "../../classes/User.class.php";

$login = new Auth();
$user = new User();
$user->dbh = $dbh;
$login->dbh = $dbh;

if(!$login->checkLoginUser()) return  header("location: ../login.php");


if(isset($_POST["currentPassword"] , $_POST["newPassword"] , $_POST["reNewPassword"])){
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $reNewPassword = $_POST["reNewPassword"];



    if(!empty(trim($currentPassword)) && !empty(trim($newPassword)) && !empty(trim($reNewPassword))){
        if($currentPassword != $newPassword){
            if($login->checkUser($_SESSION["email"] , $currentPassword)){
                if($login->checkPasswordStrength($newPassword)){
                    if($login->checkPasswordRepeat($newPassword , $reNewPassword)){
                        $user->editUserPassword($_SESSION["email"] , $newPassword);
                        $login->logout();
                    } else {
                        echo "new password and repeat not same";
                    }
                } else {
                    echo "new password is not strong";
                }
            } else {
                echo "current password is invalid";
            }
        } else {
            echo "The old password cannot be the same as the new one";
        }
    } else {
        echo "please fill out the form";
    }

}

$user_information = $user->getUser($_SESSION["email"]);

?>
<hr>

<?php 
    echo "First Name: " . $user_information["fname"] . "<br>";
    echo "Last Name: " . $user_information["lname"]  . "<br>" ;
    echo "Email: " . $user_information["email"]  . "<br>";
?>
<hr>
#change Password
<form action="" method="post">
    <input type="text" name="currentPassword" placeholder="Enter your current password"><br>
    <input type="text" name="newPassword" placeholder="Enter your new password"><br>
    <input type="text" name="reNewPassword" placeholder="Enter your repeat new password"><br>
    <button type="submit">Change Password</button>
</form>
<hr>
<a href="posts.php">Posts / Add a post</a><br>
<a href="logout.php">Log out</a>