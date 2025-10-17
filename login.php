<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database to check user credentials
    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Regenerate session ID to prevent session fixation and sharing
            session_regenerate_id(true);

            // Store user data in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            // Check if the email is for admin
            if ($email === "notesnest3064@gmail.com") {  
                $_SESSION['is_admin'] = true;
                header("Location: admin.php"); // Redirect to admin page
            } else {
                $_SESSION['is_admin'] = false;
                header("Location: dashboard.php"); // Redirect to user dashboard
            }
            exit();
        } else {
            $error = "❌ Incorrect password!";
        }
    } else {
        $error = "❌ No account found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet"href="./assets/login.css">
</head>
<body>
   <div class="container">
    <div class="card">
        <div class="box">
            <div class="glass"></div>
            <div class="content">
            <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <div class="form">
    <form method="POST">
    <p>Login</p>
        
        <input id = "mail"type="email" name="email" placeholder="Email" required>
        
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    </div>
   
    <div class="signup">
        <p>Dont you have an account ? <a href="signup.php">Register</a></p>
    </div>
            </div>
        </div>
    </div>
   </div>
</body>
</html