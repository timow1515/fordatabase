<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "new_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);
try {
  $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // Set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
