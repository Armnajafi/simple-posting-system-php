<?php

class Contact{
    public $dbh;

    public function allMessages()
    {
        try {
            $stmt = $this->dbh->prepare("SELECT *, (SELECT COUNT(*) FROM messages) as count FROM messages");
            $stmt->execute();

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function checkPhoneNumber($phoneNumber){
        if(preg_match("/^09[0-9]{9}$/", $phoneNumber)){
            return true;
        } else {
            return false;
        }
    }
    public function getMessage($id, $email)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM user_post WHERE id = :id and user=:user");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":user", $email, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addMessage($phone, $message, $province, $city)
    {
        try {
            $stmt = $this->dbh->prepare("INSERT INTO messages (phone , message , province , city) VALUES(:phone , :message , :province , :city)");
            $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
            $stmt->bindParam(":message", $message, PDO::PARAM_STR);
            $stmt->bindParam(":province", $province, PDO::PARAM_STR);
            $stmt->bindParam(":city", $city, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function removeMessage($id)
    {
        try {
            $stmt = $this->dbh->prepare("DELETE FROM messages WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
