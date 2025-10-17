<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php';

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id, file_name, file_path, uploaded_at, status FROM files WHERE user_id = ? ORDER BY uploaded_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Uploads</title>
    <link rel="stylesheet" href="./assets/yourrequests.css">
</head>
<body>
    <div class="container">
        <h3>📁 My Uploads</h3>
        
        <div class="file-cards">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <div class="card-header">
                        <span class="file-name"><?= htmlspecialchars($row['file_name']) ?></span>
                        <span class="status-badge <?= $row['status'] ?>">
                            <?php
                            if ($row['status'] === 'approved') {
                                echo "✅ Approved";
                            } elseif ($row['status'] === 'pending') {
                                echo "⏳ Pending";
                            } else {
                                echo "❌ Rejected";
                            }
                            ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="upload-date">Uploaded on: <?= htmlspecialchars($row['uploaded_at']) ?></p>
                        <div class="actions">
                            <a href="<?= htmlspecialchars($row['file_path']) ?>" class="btn-download" download>Download</a>
                            <a href="#" class="btn-delete">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
?>