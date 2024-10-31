<?php
session_start();

if (isset($_SESSION['username']) && isset($_GET['path'])) {
    $filePath = $_GET['path'];
    $content = getFileContent($filePath);
    echo htmlspecialchars($content);
} else {
    http_response_code(403);
    echo "Access denied";
}

function getFileContent($filePath) {
    $filePath = __DIR__.'/../../gra_files_storage' . $filePath;
    if (file_exists($filePath) && is_readable($filePath)) {
        return file_get_contents($filePath);
    } else {
        return "Error: El archivo no existe o no se puede leer.";
    }
}

?>
