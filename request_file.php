<?php
session_start();
require 'config.php';

$notification = '';
$notification_class = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $request_text = trim($_POST['request_text']);
    $file_id = null; // Default to NULL since file might not exist yet

    if (!empty($request_text)) {
        $stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($user_email);
        $stmt->fetch();
        $stmt->close();

        if (!empty($user_email)) {
            // Insert request with file_id as NULL
            $stmt = $conn->prepare("INSERT INTO file_requests (user_id, user_email, request_text, file_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("issi", $user_id, $user_email, $request_text, $file_id);

            if ($stmt->execute()) {
                $notification = "✅ Request submitted successfully!";
                $notification_class = "success";
            } else {
                $notification = "❌ Error submitting request.";
                $notification_class = "error";
            }
        } else {
            $notification = "❌ Error: User email not found.";
            $notification_class = "error";
        }
    } else {
        $notification = "❌ Request text cannot be empty.";
        $notification_class = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Request</title>
    <link rel="stylesheet" href="./assets/request_file.css">
</head>
<body>
    <div class="request-container">
        <h1>File Request Form</h1>
        
        <?php if (!empty($notification)): ?>
            <div class="notification <?php echo $notification_class; ?>">
                <?php echo $notification; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label for="request_text">What file do you need?</label>
            <input type="text" name="request_text" 
                   placeholder="Enter your request here..." 
                   required>
            <button type="submit">Submit Request →</button>
        </form>

        <div class="view-requests-link">
            <a href="view-requests.php">View All Requests →</a>
        </div>
    </div>
</body>
</html>
