<?php
$servername = "localhost";
$username = "root";
$password = ""; // No password in XAMPP by default
$dbname = "otp_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
