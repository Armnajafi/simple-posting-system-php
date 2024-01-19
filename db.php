<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'arian');
define('DB_USER', '..');
define('DB_PASSWORD', '..');

try {
  // Create a new PDO instance
  $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
//   $mysqli = new mysqli($hostname, $username, $password, $database);

} catch(PDOException $e) {
  // Handle connection errors
  echo "Connection failed: " . $e->getMessage();
}