<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SERVER['APP']) || empty($_SERVER['APP'])) {
    $_SERVER['APP'] = dirname(__DIR__, 2) . '/premiumcheckings.app/pc.php';
}
if (!isset($_SERVER['PROJECT_ROOT']) || empty($_SERVER['PROJECT_ROOT'])) {
    $_SERVER['PROJECT_ROOT'] = dirname(__DIR__, 2) . '/';
}
include_once $_SERVER['APP'];
include_once WEB_ROOT . "backend/config.php";
include_once WEB_ROOT . "backend/functions.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $otp = isset($_POST['otp']) ? trim(secure_input($_POST['otp'])) : '';
    $email = isset($_POST['email']) ? trim(secure_input($_POST['email'])) : '';

    if (empty($otp)) {
        echo "Please enter the 6-digit verification code.";
        exit();
    }

    if (!preg_match('/^[0-9]{6}$/', $otp)) {
        echo "The verification code must be exactly 6 digits.";
        exit();
    }

    // Determine user by session or email
    $user_id = isset($_SESSION['pending_activation_user_id']) ? intval($_SESSION['pending_activation_user_id']) : 0;
    
    if ($user_id > 0) {
        $stmt = "SELECT * FROM users WHERE id = '{$user_id}' LIMIT 1";
    } elseif (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_escaped = mysqli_real_escape_string($conn, $email);
        $stmt = "SELECT * FROM users WHERE email = '{$email_escaped}' LIMIT 1";
    } else {
        echo "Session expired. Please sign in or register again.";
        exit();
    }

    $result = mysqli_query($conn, $stmt);
    if (!$result || mysqli_num_rows($result) === 0) {
        echo "User record not found. Please register again.";
        exit();
    }

    $user = mysqli_fetch_assoc($result);
    $user_id = $user['id'];

    // Check if user is already activated
    if ($user['status'] == '1') {
        $_SESSION['userlogin'] = true;
        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $user_id;
        unset($_SESSION['pending_activation_user_id']);
        unset($_SESSION['pending_activation_email']);
        echo "success";
        exit();
    }

    // Check if account is banned
    if ($user['status'] == '-1') {
        echo "This account has been banned. Please contact support.";
        exit();
    }

    // Check OTP code
    if (empty($user['otp_code']) || $user['otp_code'] !== $otp) {
        echo "Invalid verification code. Please check your email and try again.";
        exit();
    }

    // Check expiration
    if (!empty($user['otp_expiry']) && strtotime($user['otp_expiry']) < time()) {
        echo "Verification code has expired. Please click 'Resend Code' to receive a new one.";
        exit();
    }

    // Activate user account
    $update = "UPDATE users SET status = '1', otp_code = NULL, otp_expiry = NULL WHERE id = '{$user_id}'";
    if (mysqli_query($conn, $update)) {
        $_SESSION['userlogin'] = true;
        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $user_id;
        unset($_SESSION['pending_activation_user_id']);
        unset($_SESSION['pending_activation_email']);
        echo "success";
        exit();
    } else {
        echo "Failed to activate account. Please try again.";
        exit();
    }
}
