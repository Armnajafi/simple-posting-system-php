<?php
session_start();
include "../../db.php";
include "../../classes/Auth.class.php";
include "../../classes/Contact.class.php";
$login = new Auth();

if (!$login->checkLoginAdmin()) return  header("location: ../login.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    if (is_numeric($id)) {
        try {
            $contact = new Contact();
            $contact->dbh = $dbh;
            $contact->removeMessage($id);
            header("location: index.php");
        } catch (\Throwable $th) {
            echo "problem to fetch and delete";
        }
    } else {
        header("location: index.php");
    }
}
