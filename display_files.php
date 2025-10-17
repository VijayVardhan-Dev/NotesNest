<?php
require 'config.php';

$result = $conn->query("SELECT * FROM files WHERE status = 'approved' ORDER BY uploaded_at DESC");

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Uploaded Files</title>
    <link rel='stylesheet' href='./assets/display.css'>
</head>
<body>
    <div class='container'>
        <h2>Uploaded Files</h2>
        <div class='files-grid'>";

if ($result->num_rows === 0) {
    echo "<div class='empty-state'>No approved files found</div>";
} else {
    $index = 0;
    while ($row = $result->fetch_assoc()) {
        $filePath = htmlspecialchars($row['file_path']);
        $fileName = htmlspecialchars($row['file_name']);
        $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $filePath);

        echo "<div class='file-card' style='--index: {$index};'>
                <div class='card-image'>
                    " . ($isImage ? 
                        "<img src='{$filePath}' alt='Preview of {$fileName}' class='file-preview' loading='lazy' onload=\"this.parentElement.classList.add('loaded')\">" :
                        "<div class='default-preview'></div>"
                    ) . "
                </div>
                <div class='card-content'>
                    <div class='file-name'>{$fileName}</div>
                    <div class='buttons-container'>
                        <a href='{$filePath}' class='btn btn-view' target='_blank'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 0 16 16'>
                                <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z'/>
                                <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0'/>
                            </svg>
                            View
                        </a>
                        <a href='download.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-download'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-download' viewBox='0 0 16 16'>
                                <path d='M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5'/>
                                <path d='M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z'/>
                            </svg>
                            Download
                        </a>
                    </div>
                </div>
            </div>";
        $index++;
    }
}

echo "</div>
    </div>
</body>
</html>";