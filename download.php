<?php
require 'config.php'; // Database connection

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input

    // Get file details from database
    $stmt = $conn->prepare("SELECT file_name, file_path FROM files WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($fileName, $filePath);
    $stmt->fetch();
    $stmt->close();

    if ($filePath && file_exists($filePath)) {
        // Force file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        readfile($filePath);
        exit;
    } else {
        die("❌ File not found on server: " . $filePath);
    }
} else {
    die("❌ Invalid request.");
}
?>
