<?php
    session_start();
    $target_dir = "../../uploads/";
    include "../../db.php";
    include "../../classes/Auth.class.php";
    include "../../classes/Post.class.php";
    $login = new Auth();

    if(!$login->checkLoginUser()) return  header("location: login.php");
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        if(is_numeric($id)){
            $post = new Post();
            $post->dbh = $dbh;
            $post_information = $post->getPost($id , $_SESSION["email"]);
            if(isset($_POST["title"] , $_POST["description"] , $_FILES["image"])){

                $title = $_POST["title"];
                $description = $_POST["description"];
                $image = $_FILES["image"];
                $image_name = $_FILES["image"]["name"];
        
                if(!empty(trim($title)) && !empty(trim($description))){
                  
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    
                      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        if($post->editPost($id , $title , $description , $image_name , $_SESSION["email"])){
                            header("location: edit-post.php?id=".$id);
                        }
                      } else {
                        echo "Sorry, there was an error uploading your file.";
                      }
            
                } else {
                    echo "please fill out the form";
                }
            }
        } else {
            return header("location: posts.php");
        }
    } else {
        return header("location: posts.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" value="<?php echo $post_information['title']; ?>" name="title" placeholder="Post Title"><br>
        <textarea type="text" name="description" placeholder="Post Title">
            <?php echo $post_information["description"];?>
        </textarea><br>
        <img src="<?php echo $post_information["image"]; ?>" width="100px" height="100px"><br>
        <input type="file" name="image"><br><br>
        <button type="submit">Edit</button>
    </form>
</body>
</html>