<?php
session_start();
require 'config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Admin check
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("Access denied. Please log in as admin.");
}

// Handle approval/decline
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'], $_POST['file_id'])) {
    $file_id = intval($_POST['file_id']);
    $status = ($_POST['action'] == 'approve') ? 'approved' : 'declined';

    // Update file status
    $stmt = $conn->prepare("UPDATE files SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $file_id);
    $stmt->execute();
    $stmt->close();

    if ($status == 'approved') {
        // Get file + requester details
        $file_query = $conn->query("SELECT 
            f.file_name, 
            f.file_path,
            f.requester_id,
            f.requester_email,
            f.request_id,
            u.email AS uploader_email
        FROM files f
        JOIN users u ON f.user_id = u.id
        WHERE f.id = $file_id");

        if ($file_query->num_rows > 0) {
            $file = $file_query->fetch_assoc();
            $file_name = htmlspecialchars($file['file_name']);
            $file_path = htmlspecialchars($file['file_path']);
            
            // Delete associated file request
            if ($file['request_id']) {
                $delete_stmt = $conn->prepare("DELETE FROM file_requests WHERE id = ?");
                $delete_stmt->bind_param("i", $file['request_id']);
                $delete_stmt->execute();
                $delete_stmt->close();
            }

            // Send notifications
            $requester_email = $file['requester_email'];
            $requester_id = $file['requester_id'];
            $uploader_email = $file['uploader_email'];

            $mail = new PHPMailer(true);
            try {
                // SMTP Config
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'notesnest3064@gmail.com';
                $mail->Password = 'xylp khgd ocvo egbr';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Uploader Notification
                $mail->setFrom('notesnest3064@gmail.com', 'NotesNest');
                $mail->addAddress($uploader_email);
                $mail->Subject = "File Approved: $file_name";
                $mail->Body = "Your file '$file_name' was approved! Download: http://yoursite.com/$file_path";
                $mail->send();

                // Requester Notification
                if (!empty($requester_email)) {
                    $mail->clearAddresses();
                    $mail->addAddress($requester_email);
                    $mail->Subject = "Request Fulfilled: $file_name";
                    $mail->Body = "Your requested file '$file_name' is ready! Download: http://yoursite.com/$file_path";
                    $mail->send();

                    // In-app notification
                    if ($requester_id) {
                        $message = "Your requested file '$file_name' has been approved!";
                        $stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
                        $stmt->bind_param("is", $requester_id, $message);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            } catch (Exception $e) {
                echo "❌ Mail error: {$mail->ErrorInfo}";
            }
        }
    }
    header("Location: admin.php");
    exit();
}

// Get pending files
$pending_files = $conn->query("SELECT 
    f.*, 
    u.email AS uploader_email 
FROM files f
JOIN users u ON f.user_id = u.id 
WHERE f.status = 'pending'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="./assets/admin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h2>📋 Pending Approvals</h2>
    
    <?php if ($pending_files->num_rows > 0): ?>
        <table>
            <tr>
                <th>File Name</th>
                <th>Uploader/Requester Email</th>
                <th>Actions</th>
            </tr>
            <?php while ($file = $pending_files->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($file['file_name']) ?></td>
                    <td>
                        <?= !empty($file['requester_email']) 
                            ? htmlspecialchars($file['requester_email']) 
                            : htmlspecialchars($file['uploader_email']) ?>
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="<?= htmlspecialchars($file['file_path']) ?>" 
                               class="view-button" 
                               target="_blank"
                               title="Preview file">
                               👁️ View
                            </a>
                            <form method="POST">
                                <input type="hidden" name="file_id" value="<?= $file['id'] ?>">
                                <button type="submit" name="action" value="approve">✅ Approve</button>
                                <button type="submit" name="action" value="decline">❌ Decline</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p class="empty-state">🎉 All caught up! No pending files.</p>
    <?php endif; ?>
</body>
</html>