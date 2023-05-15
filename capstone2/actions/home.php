  <?php
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
</head>
<body>
  <h1>Welcome, <?php echo $_SESSION['email']; ?></h1>
  <p>This is your home page.</p>
  <form action="logout.php" method="post">
    <input type="submit" value="Logout">
  </form>
</body>
</html>
