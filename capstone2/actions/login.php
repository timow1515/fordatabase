<?php
// Password is correct, so start a new session
session_start();

// Store data in session variables
$_SESSION["email"] = $email;

// Redirect user to home page
header("location: home.php");

session_start();

// Check if user is already logged in, if yes, redirect to home page
if(isset($_SESSION["email"])){
  header("location: home.php");
  exit;
}

// Include database connection
require_once 'db.php';

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Check if email is empty
  if(empty(trim($_POST["email"]))){
    $email_err = "Please enter email.";
  } else{
    $email = trim($_POST["email"]);
  }

  // Check if password is empty
  if(empty(trim($_POST["password"]))){
    $password_err = "Please enter your password.";
  } else{
    $password = trim($_POST["password"]);
  }

  // Validate credentials
  if(empty($email_err) && empty($password_err)){
    // Prepare a select statement
    $sql = "SELECT email, password FROM users WHERE email = :email";

    if($stmt = $pdo->prepare($sql)){
      // Bind variables to the prepared statement as parameters
      $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

      // Set parameters
      $param_email = trim($_POST["email"]);

      // Attempt to execute the prepared statement
      if($stmt->execute()){
        // Check if email exists, if yes then verify password
        if($stmt->rowCount() == 1){
          if($row = $stmt->fetch()){
            $hashed_password = $row["password"];
            if(password_verify($password, $hashed_password)){
              // Password is correct, so start a new session
              session_start();

              // Store data in session variables
              $_SESSION["email"] = $email;

              // Redirect user to home page
              header("location: home.php");
            } else{
              // Display an error message if password is not valid
              $password_err = "The password you entered was not valid.";
            }
          }
        } else{
          // Display an error message if email doesn't exist
          $email_err = "No account found with that email.";
        }
      } else{
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      unset($stmt);
    }
  }

  // Close connection
  unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <style type="text/css">
    body {
      font: 14px sans-serif;
    }

    .wrapper {
      width: 350px;
      padding: 20px;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
  <label>Password</label>
  <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
  <span class="help-block"><?php echo $password_err; ?></span>
</div>
<div class="form-group">
  <input type="submit" class="btn btn-primary" value="Login">
</div>