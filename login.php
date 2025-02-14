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

$error = ""; // To store error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Prevent SQL injection using prepared statements
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    // Authenticate user using hashed passwords
    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION['userid'] = $id; // Session-based authentication
        setcookie("username", $username, time() + 3600, "/", "", false, true); // Secure cookie with HttpOnly flag
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
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
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script> <!-- Link to JavaScript -->
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <p id="error-message" class="error"><?php echo $error; ?></p>
        <form id="loginForm" action="login.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <button type="button" id="togglePassword">Show Password</button>
            </div>
            <button type="submit">Login</button>
        </form>
        <p class="register-link">Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
