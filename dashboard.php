<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if session exists
if (!isset($_SESSION['userid'])) {
    die("<div class='dashboard-container'><p class='error-msg'>Session not found! Try logging in again.</p><a href='login.php' class='btn'>Login</a></div>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h1> Welcome to the Dashboard. 
              By Burningtone Mwatha!
        </h1>
        <p>User ID: <?php echo $_SESSION['userid']; ?></p>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</body>
</html>
