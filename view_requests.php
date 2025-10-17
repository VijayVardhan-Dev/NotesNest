<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch file requests along with file details (if linked)
$sql = "SELECT fr.id, fr.request_text, fr.user_email, fr.file_id, 
               f.file_name, f.file_path 
        FROM file_requests fr
        LEFT JOIN files f ON fr.file_id = f.id
        ORDER BY fr.id DESC";

$requests = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Requests</title>
    <link rel="stylesheet" href="./assets/view-requests.css">
</head>
<body>
    <div class="container">
        <h1>File Requests</h1>
        <?php if ($requests->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Request</th>
                    <th>Requester Email</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
                <?php while ($request = $requests->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($request['request_text']) ?></td>
                        <td><?= htmlspecialchars($request['user_email']) ?></td>
                        <td>
                            <?php if ($request['file_id']): ?>
                                <a href="<?= htmlspecialchars($request['file_path']) ?>" download>
                                    📂 <?= htmlspecialchars($request['file_name']) ?>
                                </a>
                            <?php else: ?>
                                ❌ Not Uploaded
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$request['file_id']): ?>
                                <a href="upload.php?request_id=<?= $request['id'] ?>" class="button">📤 Upload</a>
                            <?php else: ?>
                                ✅ File Available
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No active requests.</p>
        <?php endif; ?>
    </div>
</body>
</html>
