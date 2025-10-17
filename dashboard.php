<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php';

$user_id = $_SESSION['user_id'];

// Fetch user details to ensure session data is correct
$result = $conn->query("SELECT name FROM users WHERE id = $user_id");

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['user_name'] = $user['name']; // Store correct username
}

// Fetch notifications count for the logged-in user
$noti_result = $conn->query("SELECT COUNT(*) as count FROM notifications WHERE user_id = $user_id AND is_read = 0");
$noti_data = $noti_result->fetch_assoc();
$noti_count = $noti_data['count'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="./assets/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
</head>
<body>
<div class="header">
    <h2>Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 👋</h2>
    <div class="notification-logout">
        <!-- Notification Icon with Badge -->
        <a href="notifications.php" class="notification-icon">
            <i class="fas fa-bell"></i> <!-- Font Awesome bell icon -->
            <?php if ($noti_count > 0): ?>
                <span class="notification-badge"><?php echo $noti_count; ?></span>
            <?php endif; ?>
        </a>
        <!-- Logout Button -->
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>
    <div class="main">
        <div class="slideshow-container">
            <div class="slides">
                <div class="slide"><img src="./assets/g5.avif" alt="Slide 2"></div>
                <div class="slide"><img src="./assets/g2.avif" alt="Slide 1"></div>
                <div class="slide"><img src="./assets/g4.avif" alt="Slide 3"></div>
            </div>
            <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="next" onclick="moveSlide(1)">&#10095;</button>
        </div>
    </div>

  
    </div>
    <div class="card-container">
        <a href="upload.php" class="card">
            <h3>📤 Upload Notes</h3>
        </a>
        <a href="display_files.php" class="card">
            <h3>📚 View Notes</h3>
        </a>
        <a href="request_file.php" class="card">
            <h3>📥 Request Files</h3>
        </a>
        <a href="yourrequests.php" class="card">
            <h3>📋 My Uploads</h3>
        </a>
    </div>
    <h2>Requested Files</h2>

<?php


$sql = "SELECT file_requests.id, file_requests.request_text, 
               users.name, file_requests.requested_at 
        FROM file_requests 
        JOIN users ON file_requests.user_id = users.id 
        ORDER BY file_requests.requested_at DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="requests-table">';
    echo '<tr><th>Requester Name</th><th>Request Message</th><th>Requested At</th><th>Action</th></tr>';
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['request_text']}</td>
                <td>{$row['requested_at']}</td>
                <td><a class='upload-link' href='upload.php?request_id={$row['id']}'>Upload File</a></td>
              </tr>";
    }
    echo '</table>';
}
?>

<script src="./assets/dashboard.js"></script>
</body>
</html>