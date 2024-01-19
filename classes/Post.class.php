<?php

class Post{
    public $dbh;

    public function allPosts(){
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM user_post");
            $stmt->execute();

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        } catch (\Throwable $th) {
            throw $th;
        }  
    }
    public function allPostsByUser($email){
        try {
            $stmt = $this->dbh->prepare("SELECT *, (SELECT COUNT(*) FROM user_post WHERE user = :email ) as count FROM user_post WHERE user=:email;");
            $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //if($row["count"] > 0){
                return $row ;
            //} else {
            //    return false;
            //}
        } catch (\Throwable $th) {
            throw $th;
        }  
    }
    public function getPost($id , $email){
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM user_post WHERE id = :id and user=:user");
            $stmt->bindParam(":id" , $id , PDO::PARAM_INT);
            $stmt->bindParam(":user" , $email , PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
            return $row;
        } catch (\Throwable $th) {
            throw $th;
        }    
    }

    public function addPost($title , $description , $image , $user){
        try {
            $stmt = $this->dbh->prepare("INSERT INTO user_post (title , description , image , user) VALUES(:title , :description , :image , :user)");
            $stmt->bindParam(":title" , $title , PDO::PARAM_STR);
            $stmt->bindParam(":description" , $description , PDO::PARAM_STR);
            $stmt->bindParam(":image" , $image , PDO::PARAM_STR);
            $stmt->bindParam(":user" , $user , PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }  
    }
    public function editPost($id , $title , $description , $image, $email){
            try {
                if($image == ""){
                    $stmt = $this->dbh->prepare("UPDATE user_post SET title  = :title , description=:description  WHERE user = :email and id = :id");   
                } else {
                    $stmt = $this->dbh->prepare("UPDATE user_post SET title  = :title , description=:description , image=:image WHERE user = :email and id = :id");
                    $stmt->bindParam(":image" , $image , PDO::PARAM_STR);
                }
                $stmt->bindParam(":title" , $title , PDO::PARAM_STR);
                $stmt->bindParam(":description" , $description , PDO::PARAM_STR);    
                $stmt->bindParam(":email" , $email , PDO::PARAM_STR);    
                $stmt->bindParam(":id" , $id , PDO::PARAM_INT);   
                $stmt->execute();
                
                return true;
            } catch (\Throwable $th) {
                throw $th;
            }  
    }
    public function removePost($email, $id){
             try {
                 $stmt = $this->dbh->prepare("DELETE FROM user_post WHERE user = :email and id = :id");
                 $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
                 $stmt->bindParam(":id" , $id , PDO::PARAM_INT);
                 $stmt->execute();
                 return true;
             } catch (\Throwable $th) {
                 throw $th;
             }  
     }
}

