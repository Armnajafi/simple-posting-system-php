<?php
    session_start();
    include "../db.php";
    include "../../classes/Auth.class.php";
    include "../../classes/Post.class.php";
    $login = new Auth();

    if(!$login->checkLoginUser()) return  header("location: login.php");
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        if(is_numeric($id)){
            try {
                $post = new Post();
                $post->dbh = $dbh;
                $post->removePost($_SESSION["email"] , $id);
                header("location: posts.php");
            } catch (\Throwable $th) {
               echo "problem to fetch and delete";
            }
        } else {
            header("location: posts.php");
        }
    }
?>