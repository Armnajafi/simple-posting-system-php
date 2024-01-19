<?php
    include "../../classes/Auth.class.php";

    $login = new Auth();
    $login->logout();
    return header("location: ../login.php");
?>