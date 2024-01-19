<?php
    session_start();
    $target_dir = "uploads/";
    include "db.php";
    include "classes/Post.class.php";
    $post = new Post();
    $post->dbh = $dbh;
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <?php
        if(isset($_SESSION["isUser"])){
            echo "Welcome To ...<br>";
            echo "<a href='pages/user/profile.php'>Profile</a>";
        } else {
            echo ' <a href="pages">Login</a>';
        }
    ?>
   
    <hr>
    <h3>Posts</h3>
    <?php
    foreach ($post->allPosts() as $row) {
        echo "<img src='".$target_dir.$row["image"]."'>" . "<br>";
        echo $row["title"] . "<br>";
        echo $row["description"] . "<br>";
        echo $row["user"]. "<hr>";
    }
    ?>
</body>
</html>