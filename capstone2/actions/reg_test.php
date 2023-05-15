<?php
//include the db.php in all your action files
require_once('db.php');

// Get user input from form
if (isset($_POST['firstname'])) {
  $firstname = $_POST['firstname'];
}
if (isset($_POST['lastname'])) {
  $lastname = $_POST['lastname'];
}
if (isset($_POST['contact_number'])) {
  $contact_number = $_POST['contact_number'];
}
if (isset($_POST['address'])) {
  $address = $_POST['address'];
}if (isset($_POST['email'])) {
  $email = $_POST['email'];
}if (isset($_POST['password'])) {
  $password = $_POST['password'];
}
// Insert user input into database
$sql = "INSERT INTO users (firstname, lastname, contact_number,address,email,password) VALUES ('$firstname', '$lastname', '$contact_number','$address','$email','$password')";

if (mysqli_query($conn, $sql)) {
  header("location:../index.php?success=New record created successfully");
} else {
  header("location:../index.php?failed=Register Failed");
}

mysqli_close($conn);
