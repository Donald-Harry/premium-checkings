<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "backend/config.php";
include_once WEB_ROOT . "backend/functions.php";

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized. Please log in.";
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id_type = isset($_POST['id_type']) ? mysqli_real_escape_string($conn, secure_input($_POST['id_type'])) : '';
    $id_number = isset($_POST['id_number']) ? mysqli_real_escape_string($conn, secure_input($_POST['id_number'])) : '';

    if (empty($id_type)) {
        echo "Please select an ID document type.";
        exit();
    }

    // Check if files are uploaded
    if (!isset($_FILES['id_front']) || $_FILES['id_front']['error'] === UPLOAD_ERR_NO_FILE) {
        echo "Please upload the FRONT of your ID card.";
        exit();
    }

    if (!isset($_FILES['id_back']) || $_FILES['id_back']['error'] === UPLOAD_ERR_NO_FILE) {
        echo "Please upload the BACK of your ID card.";
        exit();
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];
    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    $uploadDir = WEB_ROOT . "backend/account/kycDocuments/";
    if (!file_exists($uploadDir)) {
        @mkdir($uploadDir, 0777, true);
    }

    // Process ID Front
    $frontFile = $_FILES['id_front'];
    if ($frontFile['error'] !== UPLOAD_ERR_OK) {
        echo "Error uploading front ID image. Error code: " . $frontFile['error'];
        exit();
    }
    if ($frontFile['size'] > $maxSize) {
        echo "Front ID file is too large. Maximum size is 5MB.";
        exit();
    }
    $frontExt = strtolower(pathinfo($frontFile['name'], PATHINFO_EXTENSION));
    $frontMime = mime_content_type($frontFile['tmp_name']);
    if (!in_array($frontExt, $allowedExtensions) || !in_array($frontMime, $allowedMimes)) {
        echo "Invalid front ID file type. Allowed formats: JPG, PNG, WEBP, PDF.";
        exit();
    }
    $frontFileName = "kyc_front_" . $user_id . "_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $frontExt;
    $frontTarget = $uploadDir . $frontFileName;

    // Process ID Back
    $backFile = $_FILES['id_back'];
    if ($backFile['error'] !== UPLOAD_ERR_OK) {
        echo "Error uploading back ID image. Error code: " . $backFile['error'];
        exit();
    }
    if ($backFile['size'] > $maxSize) {
        echo "Back ID file is too large. Maximum size is 5MB.";
        exit();
    }
    $backExt = strtolower(pathinfo($backFile['name'], PATHINFO_EXTENSION));
    $backMime = mime_content_type($backFile['tmp_name']);
    if (!in_array($backExt, $allowedExtensions) || !in_array($backMime, $allowedMimes)) {
        echo "Invalid back ID file type. Allowed formats: JPG, PNG, WEBP, PDF.";
        exit();
    }
    $backFileName = "kyc_back_" . $user_id . "_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $backExt;
    $backTarget = $uploadDir . $backFileName;

    // Move files
    if (!move_uploaded_file($frontFile['tmp_name'], $frontTarget)) {
        echo "Failed to save front ID file.";
        exit();
    }

    if (!move_uploaded_file($backFile['tmp_name'], $backTarget)) {
        // Clean up front if back fails
        @unlink($frontTarget);
        echo "Failed to save back ID file.";
        exit();
    }

    // Update database
    $query = "UPDATE users SET 
        id_type = '{$id_type}',
        id_number = '{$id_number}',
        id_front = '{$frontFileName}',
        id_back = '{$backFileName}',
        kyc_status = 'pending',
        kyc_submitted_at = NOW(),
        kyc_reason = NULL
        WHERE id = '{$user_id}'";

    if (mysqli_query($conn, $query)) {
        echo "success";
        exit();
    } else {
        echo "Database update failed: " . mysqli_error($conn);
        exit();
    }
} else {
    echo "Invalid request method.";
    exit();
}
