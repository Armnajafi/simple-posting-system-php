<?php

class User{
    public $dbh;

    public function getUser($email){
        try {
            $stmt = $this->dbh->prepare("SELECT *, (SELECT COUNT(*) FROM users WHERE email = :email ) as count FROM users WHERE email=:email;");
            $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
            if($row["count"] > 0){
                return $row;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }    
    }

    public function addUser($fname , $lname , $email , $password){
        try {
            $stmt = $this->dbh->prepare("INSERT INTO users (fname , lname , email , password) VALUES(:fname , :lname , :email , :password)");
            $stmt->bindParam(":fname" , $fname , PDO::PARAM_STR);
            $stmt->bindParam(":lname" , $lname , PDO::PARAM_STR);
            $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
            $stmt->bindParam(":password" , $password , PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }  
    }
    public function editUserPassword($email, $newPassword){
       if($this->getUser($email)){
            try {
                $stmt = $this->dbh->prepare("UPDATE users SET password  = :password WHERE email = :email;");
                $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
                $stmt->bindParam(":password" , $newPassword , PDO::PARAM_STR);

                $stmt->execute();
                return true;
            } catch (\Throwable $th) {
                throw $th;
            }  
       }
    }
}

