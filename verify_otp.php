<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];
    
    if ($entered_otp == $_SESSION['otp']) {
        // Save user to database
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];

        $conn->query("INSERT INTO users (name, email, password, verified) VALUES ('$name', '$email', '$password', 1)");
        
        unset($_SESSION['otp']); // Remove OTP session
        unset($_SESSION['name']); // Clear session data
        unset($_SESSION['email']);
        unset($_SESSION['password']);

        // Display success message and redirect to login page
        echo "<script>
                alert('Registration successful! Redirecting to login page...');
                window.location.href = 'login.php';
              </script>";
        exit;
    } else {
        $error_message = "Invalid OTP!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify OTP</title>
    <link rel="stylesheet" href="./assets/verify_otp.css">
</head>
<body>
   <div class="container">
    <div class="card">
        <div class="box">
            <div class="glass"></div>
            <div class="content">
                <form method="POST">
                    <input type="text" name="otp" placeholder="Enter OTP" required>
                    <button type="submit">Verify</button>
                    <?php
                    if (isset($error_message)) {
                        echo "<p style='color: red;'>{$error_message}</p>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
   </div>
</body>
</html>