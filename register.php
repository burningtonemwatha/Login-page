<?php
session_start();
$host = 'localhost';
$db = 'login_prog';
$user = 'root';
$pass = '';

// Establish secure database connection
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = ""; // Variable to store error messages
$success = ""; // Variable to store success messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hashing

    // Prevent SQL Injection using prepared statements
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $success = "Registration successful! <a href='login.php'>Login here</a>";
    } else {
        $error = "Error: Username might already exist.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script> <!-- Link to JavaScript -->
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <p id="error-message" class="error"><?php echo $error; ?></p>
        <p id="success-message" class="success"><?php echo $success; ?></p>
        <form id="registerForm" action="register.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                <p id="username-status"></p>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
