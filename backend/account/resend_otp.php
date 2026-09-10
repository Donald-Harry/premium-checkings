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
include_once WEB_ROOT . "backend/mailer.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = isset($_POST['email']) ? trim(secure_input($_POST['email'])) : '';

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

    if ($user['status'] == '1') {
        echo "Your account is already active. Please sign in.";
        exit();
    }

    // Rate-limiting check: minimum 45 seconds between resends
    if (isset($_SESSION['last_otp_sent_time']) && (time() - $_SESSION['last_otp_sent_time']) < 45) {
        $wait = 45 - (time() - $_SESSION['last_otp_sent_time']);
        echo "Please wait {$wait} seconds before requesting another code.";
        exit();
    }

    // Generate new OTP
    $otp_code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $update = "UPDATE users SET otp_code = '{$otp_code}', otp_expiry = DATE_ADD(NOW(), INTERVAL 15 MINUTE) WHERE id = '{$user_id}'";

    if (mysqli_query($conn, $update)) {
        $_SESSION['pending_activation_user_id'] = $user_id;
        $_SESSION['pending_activation_email'] = $user['email'];
        $_SESSION['last_otp_sent_time'] = time();

        $fullName = trim($user['first_name'] . ' ' . $user['last_name']);
        if (empty($fullName)) {
            $fullName = $user['username'];
        }

        $sent = send_otp_email($user['email'], $fullName, $otp_code);
        if ($sent) {
            echo "success";
            exit();
        } else {
            echo "Failed to send email. Please check your network or try again shortly.";
            exit();
        }
    } else {
        echo "Unable to generate new code. Please try again.";
        exit();
    }
}
