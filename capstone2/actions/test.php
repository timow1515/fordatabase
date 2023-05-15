<?php
require_once('dbcon.php');
// Check if the form was submitted

if (isset($_POST['submit'])) {

// Sanitize the input
$firstname = htmlspecialchars($_POST['firstname']);
$lastname = htmlspecialchars($_POST['lastname']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$address = htmlspecialchars($_POST['address']);
$contactnumber = htmlspecialchars($_POST['contactnumber']);

// Check if the email address is already in the database
$sql = "SELECT * FROM register WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

// If the email address is already in the database, redirect the user back to the registration page
if (mysqli_num_rows($result) > 0) {
header("Location: index.php?error=emailalreadyexists");
exit;
}

// Hash the password
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Insert the user into the database
$sql = "INSERT INTO users (firstname, lastname, email, password, address, contactnumber) VALUES ('$firstname', '$lastname', '$email', '$password_hash', '$address', '$contactnumber')";
mysqli_query($conn, $sql);

// Redirect the user to the login page
header("Location: login.php");
exit;
}
?>
