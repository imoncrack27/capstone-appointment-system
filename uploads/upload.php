<?php
$targetDir = __DIR__ . '/uploads';
$response = [];

if (!empty($_FILES['fileInput'])) {
    $files = $_FILES['fileInput'];

    foreach ($files['tmp_name'] as $index => $tmpName) {
        $targetFile = $targetDir . $files['name'][$index]; // Use the original filename

        if (move_uploaded_file($tmpName, $targetFile)) {
            $response[] = 'File ' . $files['name'][$index] . ' has been uploaded.';
        } else {
            $response[] = 'Error uploading ' . $files['name'][$index];
        }
    }
} else {
    $response[] = 'No files were uploaded.';
}

header('Content-Type: application/json');
echo json_encode($response);
