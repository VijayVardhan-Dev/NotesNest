<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view notifications.");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clear_all'])) {
    $conn->query("DELETE FROM notifications WHERE user_id = $user_id");
    header("Location: notifications.php");
    exit;
}

$result = $conn->query("SELECT * FROM notifications WHERE user_id = $user_id ORDER BY created_at DESC");

// Start of HTML output
echo '<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="./assets/notifications.css">
</head>
<body>
<div class="notification-container">';

echo "<h2>Notifications</h2>";

echo "<form method='POST' action='notifications.php' onsubmit=\"return confirm('Are you sure you want to clear all notifications?');\">
        <button type='submit' name='clear_all'>Clear All Notifications</button>
      </form>";

if ($result->num_rows > 0) {
    echo "<ul>";
    $animation_delay = 0.2;
    while ($row = $result->fetch_assoc()) {
        echo "<li style='animation-delay: {$animation_delay}s'>";
        echo $row['message'];

        preg_match("/href='(.*?)'/", $row['message'], $matches);
        $file_path = $matches[1] ?? '';

        if (!empty($file_path)) {
            echo " - <a href='$file_path' target='_blank'><button>View</button></a>";
            echo " <a href='$file_path' download><button>Download</button></a>";
        }

        echo "</li>";
        $animation_delay += 0.1;
        $conn->query("UPDATE notifications SET is_read = 1 WHERE id = {$row['id']}");
    }
    echo "</ul>";
} else {
    echo "<p>No notifications yet.</p>";
}

echo '</div>
</body>
</html>';
?>