<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "backend/config.php";
include_once WEB_ROOT . "backend/functions.php";

if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    echo "Unauthorized access.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $user_id = isset($_POST['user_id']) ? mysqli_real_escape_string($conn, secure_input($_POST['user_id'])) : '';
    $action = isset($_POST['action']) ? mysqli_real_escape_string($conn, secure_input($_POST['action'])) : '';
    $reason = isset($_POST['reason']) ? mysqli_real_escape_string($conn, secure_input($_POST['reason'])) : '';

    if (empty($user_id) || empty($action)) {
        echo "Missing required parameters.";
        exit();
    }

    if ($action === 'approve') {
        $update = mysqli_query($conn, "UPDATE users SET kyc_status = 'approved', kyc_reason = NULL WHERE id = '{$user_id}'");
        if ($update) {
            echo "success";
            exit();
        } else {
            echo "Failed to approve: " . mysqli_error($conn);
            exit();
        }
    } else if ($action === 'reject') {
        $rejection_reason = !empty($reason) ? $reason : 'Submitted ID documents were unclear, expired, or invalid. Please re-upload.';
        $update = mysqli_query($conn, "UPDATE users SET kyc_status = 'rejected', kyc_reason = '{$rejection_reason}' WHERE id = '{$user_id}'");
        if ($update) {
            echo "success";
            exit();
        } else {
            echo "Failed to reject: " . mysqli_error($conn);
            exit();
        }
    } else {
        echo "Invalid action.";
        exit();
    }
} else {
    echo "Invalid request method.";
    exit();
}
