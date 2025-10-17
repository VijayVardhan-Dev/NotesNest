<?php
session_start();
require 'config.php';

// Check login status
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get request_id from URL
$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : null;
$requester_id = null;
$requester_email = null;

// Get requester details if request_id exists
if ($request_id) {
    $stmt = $conn->prepare("SELECT user_id, user_email FROM file_requests WHERE id = ?");
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $request_data = $result->fetch_assoc();
        $requester_id = $request_data['user_id'];
        $requester_email = $request_data['user_email'];
    }
    $stmt->close();
}

// File upload handler
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];

    // Validate and process file upload
    $allowed_types = ["application/pdf", "image/jpeg", "image/png"];
    $file_type = mime_content_type($_FILES['file']['tmp_name']);
    
    if (!in_array($file_type, $allowed_types)) {
        die("❌ Only PDF, JPG, and PNG files are allowed.");
    }

    // Create upload directory
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Generate unique filename
    $original_name = basename($_FILES['file']['name']);
    $stored_name = uniqid() . '_' . $original_name;
    $file_path = $upload_dir . $stored_name;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
        // Insert file with requester information
        $stmt = $conn->prepare("INSERT INTO files 
            (file_name, file_path, file_type, status, user_id, request_id, requester_id, requester_email) 
            VALUES (?, ?, ?, 'pending', ?, ?, ?, ?)");
        
        $stmt->bind_param("sssiiis", 
            $original_name,
            $file_path,
            $file_type,
            $user_id,
            $request_id,
            $requester_id,
            $requester_email
        );

        if ($stmt->execute()) {
            $_SESSION['upload_success'] = "✅ File uploaded successfully! Waiting for admin approval.";
        } else {
            $_SESSION['upload_error'] = "❌ Database error: " . $conn->error;
        }
        $stmt->close();
    } else {
        $_SESSION['upload_error'] = "❌ File upload failed!";
    }
    
    header("Location: upload.php" . ($request_id ? "?request_id=$request_id" : ""));
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
    <link rel="stylesheet" href="./assets/upload.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2 class="upload-title">Upload File</h2>
        
        <!-- Flash messages -->
        <?php if (isset($_SESSION['upload_success'])): ?>
            <div class="alert success animate-pop">
                <i class="fas fa-check-circle"></i>
                <?= $_SESSION['upload_success'] ?>
            </div>
            <?php unset($_SESSION['upload_success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['upload_error'])): ?>
            <div class="alert error animate-pop">
                <i class="fas fa-exclamation-circle"></i>
                <?= $_SESSION['upload_error'] ?>
            </div>
            <?php unset($_SESSION['upload_error']); ?>
        <?php endif; ?>

        <!-- Upload Form -->
        <form method="POST" enctype="multipart/form-data" class="upload-form animate-fade">
            <div class="file-input-wrapper">
                <input type="file" name="file" id="file" required accept=".pdf,.jpg,.jpeg,.png">
                <label for="file" class="file-label">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Choose a file or drag it here</span>
                </label>
                <?php if ($request_id): ?>
                    <input type="hidden" name="request_id" value="<?= $request_id ?>">
                <?php endif; ?>
            </div>
            <button type="submit" class="upload-button">
                <i class="fas fa-upload"></i> Upload File
            </button>
        </form>
    </div>

    <script>
        // Show selected filename
        document.getElementById('file').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            document.querySelector('.file-label span').textContent = fileName;
        });
    </script>
</body>
</html>