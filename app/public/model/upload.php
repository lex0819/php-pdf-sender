<?php
session_start();
require_once __DIR__ . '/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileName = $_FILES['fileToUpload']['name'];
    $fileTmpLoc = $_FILES['fileToUpload']['tmp_name'];
    $fileType = $_FILES['fileToUpload']['type'];
    $allowedTypes = ['application/pdf'];
    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . TEMP_PDF;

    if (in_array($fileType, $allowedTypes)) {
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        if ($fileActualExt === 'pdf') {
            move_uploaded_file($fileTmpLoc, $uploadPath . $fileName);
            $_SESSION['file_pdf'] = $uploadPath . $fileName;
            require_once('../view/upload.php');
        } else {
            require_once('../view/upload_error.php');
        }
    } else {
        require_once('../view/upload_error.php');
    }
} else {
    require_once('../view/upload_error.php');
}
