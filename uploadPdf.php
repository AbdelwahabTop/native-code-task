<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request method, Post required");
}

if ($_FILES["pdf"]["error"] !== UPLOAD_ERR_OK) {

    switch ($_FILES["image"]["error"]) {
        case UPLOAD_ERR_PARTIAL:
            exit('File only partially uploaded');
            break;
        case UPLOAD_ERR_NO_FILE:
            exit('No file was uploaded');
            break;
        case UPLOAD_ERR_EXTENSION:
            exit('File upload stopped by a PHP extension');
            break;
        case UPLOAD_ERR_FORM_SIZE:
            exit('File exceeds MAX_FILE_SIZE in the HTML form');
            break;
        case UPLOAD_ERR_INI_SIZE:
            exit('File exceeds upload_max_filesize in php.ini');
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            exit('Temporary folder not found');
            break;
        case UPLOAD_ERR_CANT_WRITE:
            exit('Failed to write file');
            break;
        default:
            exit('Unknown upload error');
            break;
    }
}

// Use fileinfo to get the mime type
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime_type = $finfo->file($_FILES["pdf"]["tmp_name"]);

$mime_types = ["application/pdf"];

if (!in_array($_FILES["pdf"]["type"], $mime_types)) {
    exit("Invalid file type");
}

// Move the file to the uploads folder
$destination = __DIR__ . "/uploads/" . $_FILES["pdf"]["name"];

if (!move_uploaded_file($_FILES["pdf"]["tmp_name"], $destination)) {
    exit("Failed to move file");
}
