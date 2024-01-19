<?php

class Location{
    public $dbh;

    public function getProvinces(){
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM provinces;");
            $stmt->execute();

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getCities()
    {
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM cities;");
            $stmt->execute();

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getCityById($id)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM cities WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getProvinceById($id)
    {
        try {
            $stmt = $this->dbh->prepare("SELECT * FROM provinces WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
