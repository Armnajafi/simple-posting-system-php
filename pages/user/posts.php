<?php
session_start();
$target_dir = "../../uploads/";
include "../../db.php";
include "../../classes/Auth.class.php";
include "../../classes/Post.class.php";
$login = new Auth();
$post = new Post();
$post->dbh = $dbh;
if (!$login->checkLoginUser()) return  header("location: login.php");

if (isset($_POST["title"], $_POST["description"], $_FILES["image"])) {

    $title = $_POST["title"];
    $description = $_POST["description"];
    $image = $_FILES["image"];
    $image_name = $_FILES["image"]["name"];

    if (!empty(trim($title)) && !empty(trim($description)) && $image_name != "") {
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if ($target_file) {
             if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $post->addPost($title, $description, $image_name, $_SESSION["email"]);
             } else {
             echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "please fill out the form";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Enter post title"><br>
        <textarea type="text" name="description" placeholder="Enter post Description"></textarea><br>
        <input type="file" name="image"><br>
        <button type="submit">Add Post</button>
    </form>
    <hr>
    <table width="100%">
        <tr>
            <td>Image</td>
            <td>Title</td>
            <td>Description</td>
            <td>edit</td>
            <td>delete</td>
        </tr>

        <?php
        foreach ($post->allPostsByUser($_SESSION["email"]) as $row) {
        ?>
            <tr>
                <td><img src="uploads/<?php echo $row['image'] ?>" width="100px" height="100px"></td>
                <td><?php echo $row["title"] ?></td>
                <td><?php echo $row["description"] ?></td>
                <td><a href="edit-post.php?id=<?php echo $row['id'] ?>">edit</a></td>
                <td><a href="delete-post.php?id=<?php echo $row['id'] ?>">delete</a></td>
            </tr>
        <?php
        }
        ?>

    </table>

</body>

</html>