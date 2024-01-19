<?php
class Auth{
    public $fname;
    public $lname;
    public $email;
    public $password;
    public $dbh;

    public function logout(){
        session_start();
        session_destroy();
    }
    public function checkLoginUser(){
        if(isset($_SESSION["isUser"]) && $_SESSION["isUser"]){
            return true;
        } else {
            return false;
        }
    }
    public function checkLoginAdmin(){
        if(isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"]){
            return true;
        } else {
            return false;
        }
    }
    public function checkAdmin($email , $password){
        $stmt = $this->dbh->prepare("SELECT COUNT(*) as count FROM users WHERE email = :email and password= :password and admin = 1");
        $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
        $stmt->bindParam(":password" , $password , PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
        if($row["count"] > 0){
            return true;
        } else {
            return false;
        }
    }

    public function checkUser($email , $password){
        $stmt = $this->dbh->prepare("SELECT COUNT(*) as count FROM users WHERE email = :email and password= :password");
        $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
        $stmt->bindParam(":password" , $password , PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
        if($row["count"] > 0){
            return true;
        } else {
            return false;
        }
    }

    public function register(){
        try {
            $user = new User();
            $user->addUser($this->fname , $this->lname , $this->email , $this->password);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function isValidEmail($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            return true; // Valid email address
          } else {
            return false; // Invalid email address
          }
    }

    public function checkPasswordStrength($password){
            $minimumLength = 8; // Minimum length of the password

            if (strlen($password) < $minimumLength) {
              return false;
            }
          
            // Check if the password contains uppercase letters
            if (!preg_match('/[A-Z]/', $password)) {
              return false;
            }
          
            // Check if the password contains lowercase letters
            if (!preg_match('/[a-z]/', $password)) {
              return false;
            }
          
            // Check if the password contains numbers
            if (!preg_match('/[0-9]/', $password)) {
              return false;
            }
          
            // Check if the password contains special characters
            if (!preg_match('/[^A-Za-z0-9]/', $password)) {
              return false;
            }
          
            // Password passed all checks, considered strong
            return true;
    }

    public function checkPasswordRepeat($password , $repassword){
        if($password == $repassword){
            return true; // same passowrd
        } else {
            return false; // not same password
        }
    }

    public function login(){
        if($this->email && $this->password){
            if($this->checkUser($this->email , $this->password)){
                if($this->checkAdmin($this->email , $this->password)){
                    return 2;
                } else {
                    return 1;
                }
            } else {
                return 0;
            }
        }
    }
}


?>