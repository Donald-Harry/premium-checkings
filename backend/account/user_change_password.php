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
    $current_password = isset($_POST['current_password']) ? mysqli_real_escape_string($conn, secure_input($_POST['current_password'])) : '';
    $new_password = isset($_POST['new_password']) ? mysqli_real_escape_string($conn, secure_input($_POST['new_password'])) : '';
    $confirm_password = isset($_POST['confirm_password']) ? mysqli_real_escape_string($conn, secure_input($_POST['confirm_password'])) : '';

    if (empty($current_password)) {
        echo "Please enter your current password.";
        exit();
    }

    if (empty($new_password)) {
        echo "Please enter your new password.";
        exit();
    }

    if (strlen($new_password) < 6) {
        echo "New password must be at least 6 characters long.";
        exit();
    }

    if ($new_password !== $confirm_password) {
        echo "New password and confirmation do not match.";
        exit();
    }

    if ($current_password === $new_password) {
        echo "Your new password cannot be the same as your current password.";
        exit();
    }

    // Verify current password
    $query = mysqli_query($conn, "SELECT password FROM users WHERE id = '{$user_id}'");
    if (!$query || mysqli_num_rows($query) === 0) {
        echo "User not found.";
        exit();
    }

    $row = mysqli_fetch_assoc($query);
    if ($row['password'] !== $current_password) {
        echo "Current password does not match our records.";
        exit();
    }

    // Update password
    $update = mysqli_query($conn, "UPDATE users SET password = '{$new_password}' WHERE id = '{$user_id}'");
    if ($update) {
        echo "success";
        exit();
    } else {
        echo "Failed to update password: " . mysqli_error($conn);
        exit();
    }
} else {
    echo "Invalid request method.";
    exit();
}
