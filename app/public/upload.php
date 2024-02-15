<?php
session_start();
require_once(__DIR__ . '/init.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileName = $_FILES['fileToUpload']['name'];
    $fileTmpLoc = $_FILES['fileToUpload']['tmp_name'];
    $fileType = $_FILES['fileToUpload']['type'];
    $allowedTypes = ['application/pdf'];
    $uploadPath = "./temp-pdf/";

    if (in_array($fileType, $allowedTypes)) {
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        if ($fileActualExt === 'pdf') {
            move_uploaded_file($fileTmpLoc, $uploadPath . $fileName);
            $_SESSION['file_pdf'] = $uploadPath . $fileName;
            include_once(__DIR__ . '/view/upload.php');
        } else {
            include_once(__DIR__ . '/view/upload_error.php');
        }
    } else {
        include_once(__DIR__ . '/view/upload_error.php');
    }
} else {
    include_once(__DIR__ . '/view/upload_error.php');
}
